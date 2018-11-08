<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class LockedThreadsController extends Controller
{

    /**
     * Lock the given thread.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Thread $thread)
    {
        $thread->update(['locked' => true]);

        return 'OK';
    }

    /**
     * Unlock the given thread.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\JsonResponse 
     */
    public function destroy(Thread $thread)
    {
        $thread->update(['locked' => false]);

        return 'OK';    
    }
}
