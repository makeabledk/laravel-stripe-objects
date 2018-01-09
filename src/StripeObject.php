<?php

namespace Makeable\LaravelStripeObjects;

use DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;

class StripeObject extends Eloquent
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var null
     */
    public $objectClass = null;

    /**
     * @var string
     */
    public $table = 'stripe_objects';
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'data' => 'array',
    ];

    /**
     * @var array | null
     */
    protected $relatesWith = null;

    /**
     * Add global scope 'type'
     * Attach pre-determined relation on creation.
     */
    public static function boot()
    {
        static::addGlobalScope('type', function ($query) {
            return $query->when(static::class !== StripeObject::class, function ($query) {
                $query->where('type', class_basename((new static())->objectClass));
            });
        });

        static::created(function (StripeObject $object) {
            if ($object->relatesWith) {
                list($related, $tag) = $object->relatesWith;
                $object->relations(get_class($related))->attach($related->id, ['tag' => $tag]);
            }
        });
    }

    /**
     * @param \Stripe\StripeObject $object
     *
     * @return StripeObject
     */
    public static function createFromObject(\Stripe\StripeObject $object)
    {
        return (new static())->store($object);
    }

    /**
     * @param \Stripe\StripeObject $object
     *
     * @return StripeObject
     */
    public function store(\Stripe\StripeObject $object)
    {
        $model = $this->id == $object->id ? $this : new static();
        $model->relatesWith = $this->relatesWith;
        $model->fill([
            'id' => $object->id,
            'data' => $object->jsonSerialize(),
            'type' => class_basename($object),
        ]);
        $model->save();

        // Cascade relations
        if ($this->exists && $this->id !== $model->id) {
            DB::table('stripe_object_relations')->where('stripe_object_id', $this->id)->update(['stripe_object_id' => $model->id]);
        }

        return $model;
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return Str::snake(class_basename(self::class)).'_'.$this->primaryKey;
    }

    /**
     * @param $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function relations($class)
    {
        return $this->morphedByMany($class, 'related', 'stripe_object_relations')
            ->withPivot(['tag', 'created_at', 'updated_at']);
    }

    /**
     * @param $model
     * @param $tag
     *
     * @return $this
     */
    public function relateWith($model, $tag)
    {
        $this->relatesWith = [$model, $tag];

        return $this;
    }

    /**
     * @return \Stripe\StripeObject
     */
    public function retrieve()
    {
        if (! method_exists($this->objectClass, 'retrieve')) {
            throw new \BadMethodCallException('Cannot retrieve stripe object of type '.$this->objectClass);
        }

        return tap(call_user_func([$this->objectClass, 'retrieve'], $this->id), function (\Stripe\StripeObject $fresh) {
            $this->update(['data' => $fresh->jsonSerialize()]);
        });
    }
}
