<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;
use App\Inspections\Spam;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;
use App\User;
use App\Notifications\YouWereMentioned;

class RepliesController extends Controller
{
    
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Persist a new reply.
     *
     * @param  integer           $channelId
     * @param  Thread            $thread
     * @param  CreatePostRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, CreatePostRequest $request)
    { 
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner'); 
    }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Update an existing reply.
     *
     * @param Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

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

    /**
     * Fetch all relevant replies.
     *
     * @param int    $channelId
     * @param Thread $thread
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }
}
