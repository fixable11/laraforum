<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class SearchController extends Controller
{
    public function show()
    {
        $search = request('q');

        $threads = Thread::search($search)->paginate(Thread::THREADS_PER_PAGE);

        if(request()->expectsJson()){
            return $threads;
        }

        return view('threads.index',[
            'threads' => $threads,
            'trending' => Thread::getPopular(),
        ]);
    }
}
