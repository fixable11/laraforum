<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Category;
use App\Channel;

class ThreadSubscriptionsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new thread subscription.
     *
     * @param App\Category $category
     * @param App\Channel $channel
     * @param App\Thread $thread
     */

    public function store(Category $category, Channel $channel, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Delete an existing thread subscription.
     *
     * @param App\Category $category
     * @param App\Channel $channel
     * @param App\Thread $thread
     */
    public function destroy(Category $category, Channel $channel, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
