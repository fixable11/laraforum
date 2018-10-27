<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Undocumented function
     *
     * @param [type] $channelId
     * @param \App\Thread $thread
     * @return void
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()->with('flash', 'Your reply has been left');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'Reply deleted!',
                'success' => '1',
            ]);
        }

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $body = request('body');
        $success = $reply->update(['body' => $body]);

        if ($success) {
            return response()->json([
                'success' => '1',
                'status' => 'Reply has been updated successfully!',
                'content' => $body,
            ]);
        }
    }
}
