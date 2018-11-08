<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters
{   

    /**
     * Registered filters over which operations are performed.
     *
     * @var array
     */
    protected $filters = ['by', 'popular', 'unanswered'];
    
    /**
     * Filter the query by specific username.
     *
     * @param  string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Filter the query according to those that are unanswered.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function unanswered()
    {
        $this->builder->where('replies_count', 0);
    }
}