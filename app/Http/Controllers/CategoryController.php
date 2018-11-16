<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Channel;
use App\Thread;

class CategoryController extends Controller
{


    public function index(Category $category)
    {

        return view('categories.index', [
            'trending' => Thread::getPopular(),
        ]);
    }

    public function show(Category $category)
    {

        return view('categories.show', [
            'category' => $category,
            'trending' => Thread::getPopular(),
        ]);
    }

}
