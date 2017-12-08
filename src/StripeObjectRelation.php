<?php

namespace Makeable\LaravelStripeObjects;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;

class StripeObjectRelation
{
    use HasRelationships;

    protected $model;
    protected $class;
    protected $tag;

    /**
     * StripeObjectRelation constructor.
     *
     * @param Model $model
     * @param $class
     * @param $tag
     */
    public function __construct(Model $model, $class, $tag)
    {
        $this->model = $model;
        $this->class = $class;
        $this->tag = $tag;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hasMany()
    {
        return $this->model->morphToMany($this->class, 'related', 'stripe_object_relations', 'related_id')
            ->withPivot(['tag', 'created_at', 'updated_at'])
            ->wherePivot('tag', $this->tag);
    }

    /**
     * @return Model
     */
    public function hasOne()
    {
        return $this->hasMany()->first()
            ?: (new $this->class())->relateWith($this->model, $this->tag);
    }
}
