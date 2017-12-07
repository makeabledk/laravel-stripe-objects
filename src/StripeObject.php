<?php

namespace Makeable\LaravelStripeObjects;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;

class StripeObject extends Eloquent
{
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
            return $query->where('type', class_basename((new static())->objectClass));
        });

        static::created(function (StripeObject $object) {
            if ($object->relatesWith) {
                list($related, $tag) = $object->relatesWith;
                $object->relations(get_class($related))->attach($object->id, ['tag' => $tag]);
            }
        });
    }

    /**
     * @param \Stripe\StripeObject $object
     *
     * @return StripeObject
     */
    public static function store(\Stripe\StripeObject $object)
    {
        return static::create([
            'id' => $object->id,
            'data' => $object->jsonSerialize(),
            'type' => class_basename($object),
        ]);
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
        return $this->morphedByMany($class, 'related', 'stripe_object_relations')->withPivot('tag');
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
        if (!method_exists($this->objectClass, 'retrieve')) {
            throw new \BadMethodCallException('Cannot retrieve stripe object of type '.$this->objectClass);
        }

        return tap(call_user_func([$this->objectClass, 'retrieve'], $this->id), function (\Stripe\StripeObject $fresh) {
            $this->update(['data' => $fresh->jsonSerialize()]);
        });
    }
}
