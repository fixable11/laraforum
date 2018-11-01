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

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Undocumented function
     *
     * @param [type] $channelId
     * @param \App\Thread $thread
     * @return void
     */
    public function store($channelId, Thread $thread, CreatePostRequest $request)
    { 
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner'); 
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

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $body = request('body');

            $success = $reply->update(['body' => $body]);
        } catch(\Exception $e) {
            return response('Sorry, your reply cannot be saved', 422);
        }

        if ($success) {
            return response()->json([
                'success' => '1',
                'status' => 'Reply has been updated successfully!',
                'content' => $body,
            ]);
        }
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }
}
