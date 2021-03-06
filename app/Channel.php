<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

    /**
     * The relations to greedy load on every query.
     *
     * @var array
     */
    protected $with = ['category'];

    /**
     * Get the route key name for Laravel.
     * It allows fetch data via dependency injection
     * for column other than 'id'
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Has many relation for retrieving threads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
