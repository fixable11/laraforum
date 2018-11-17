<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Notifications\ThreadWasUpdated;
use App\Events\ThreadHasNewReply;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Events\ThreadReceivedNewReply;
use App\Exceptions\ThreadIsLocked;
use App\Traits\FullTextSearch;
use Stevebauman\Purify\Facades\Purify;
use App\Category;

class Thread extends Model
{
    use RecordsActivity, FullTextSearch;

    const THREADS_PER_PAGE = 5;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to greedy load on every query.
     *
     * @var array
     */
    protected $with = ['creator'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isSubscribedTo', 'path'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean',
    ];

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'slug',
        'title',
        'body'
    ];

    /**
     * Boot the model.
     * It triggers when model creating
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {   
        return "/{$this->channel->category->slug}/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * A thread may have many replies relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A thread belongs to a creator realation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Add a reply to the thread.
     *
     * @param  array $reply
     * @return Model
     */
    public function addReply($reply)
    {
        if($this->locked){
            throw new ThreadIsLocked();
        }

        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * A thread is belongs to channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Apply all relevant thread filters.
     * This method allow to continue query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param ThreadFilters $filters
     * @return void
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Subscribe a user to the current thread.
     *
     * @param  int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    /**
     * A thread have many subscriptions relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Determine if the current user is subscribed to the thread.
     * Laravel accesor.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists(); 
    }

    /**
     * Get path attribue
     * Laravel accesor.
     *
     * @return boolean
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Determine if the thread has been updated since the user last read it.
     *
     * @param  User $user
     * @return bool
     */
    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trending()
    {
        return $this->hasOne('App\TrendingThreads', 'thread_id');
    }

    /**
     * Count and return amount of visits
     *
     * @return int|0
     */
    public function visits()
    {
        return $this->visits_count ?? '0';
    }

    /**
     * Returns popular threads
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPopular()
    {
        return self::orderBy('visits', 'desc')->take(5)->get();
    }

    /**
     * Get the route key name.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the proper slug attribute.
     * Laravel mutator.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        if(static::where('slug', $slug = str_slug($value))->exists()){
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }


    /**
     * If there is a given slug this method increment it by one
     * and return it
     *
     * @param string $slug
     * @return string
     */
    public function incrementSlug($slug)
    {
        $max = static::where('title', $this->title)->latest('id')->value('slug');

        if(is_numeric($max[-1])){
            return preg_replace_callback('/(\d+)$/', function($matches){
                return $matches[1] + 1;
            }, $max);
        }

        return "{$slug}-2";
    }

    /**
     * Mark the given reply as the best answer.
     *
     * @param Reply $reply
     */
    public function markBestReply(Reply $reply)
    {
        $this->best_reply_id = $reply->id;

        $this->save();
    }

    /**
     * Access the body attribute.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }

}
