<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;
use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use App\Thread;
use Carbon\Carbon;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['favoritesCount', 'isFavorited', 'isBest'];

    /**
     * The relations to greedy load on every query.
     *
     * @var array
     */
    protected $with = ['owner', 'favorites'];

    /**
     * Boot the reply instance.
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply){
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * The owner relation between user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A reply belongs to a thread relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Determine the path to the reply.
     *
     * @return string
     */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    /**
     * Determine if the reply was just published a moment ago.
     * This method allow restrict too frequent comments 
     * coming from user
     *
     * @return bool
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Fetch all mentioned users within the reply's body.
     * This method determine whether was there an appeal to user
     *
     * @return array
     */
    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/u', $this->body, $matches);

        return $matches[1];
    }

    /**
     * Laravel mutator for body column
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/u', '<a href="/profiles/$1">$0</a>', $body);
    }

    /**
     * Determine if the current reply is marked as the best.
     *
     * @return bool
     */
    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     *
     * Laravel accesor to determine if the current reply is 
     * marked as the best.
     *
     * @return bool
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }    
}
