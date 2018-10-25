<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters
{   

    protected $filters = ['by', 'popular'];
    
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $this->builder->where('user_id', $user->id);
    }

    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        $this->builder->orderBy('replies_count', 'desc');
    }
}