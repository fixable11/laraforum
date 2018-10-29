<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;
use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use App\Thread;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected $with = ['owner', 'favorites'];

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

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
