<?php 

namespace App\Traits;

use App\Favorite;

/**
 * 
 */
trait Favoritable
{   
    /**
     * Boot the trait.
     */
    protected static function bootFavoritable()
    {
        static::deleting(function ($model){
            $model->favorites()->each(function($model){
                $model->delete();
            });
        });
    }

    /**
     * A reply can be favorited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorite the current reply.
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    /**
     * Unfavorite the current reply.
     */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each(function ($favorite){
            $favorite->delete();
        });
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Fetch the favorited status as a property.
     *
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Get the number of favorites for the reply.
     *
     * @return integer
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}

