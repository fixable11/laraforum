<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;

class BestRepliesController extends Controller
{

    /**
     * Mark the best reply for a thread.
     *
     * @param  Reply $reply
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
        
        return 'OK';
    }
}
