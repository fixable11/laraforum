<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrendingThreads extends Model
{
    protected $fillable = ['thread_id'];

    public $timestamps = false;

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function get()
    {
        return TrendingThreads::orderBy('score', 'desc')->take(5)->get();
    }

    private function increaseTrendingScore($thread)
    {
        $trending = TrendingThreads::firstOrCreate([
            'thread_id' => $thread->id
        ]);

        $trending->score++;

        $trending->save();
    }
}
