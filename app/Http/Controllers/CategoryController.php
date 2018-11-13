<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Channel;

class CategoryController extends Controller
{


    public function index(Category $category)
    {

        return view('categories.index', [
            'trending' => [],
        ]);
    }

    public function show(Category $category)
    {

        return view('categories.show', [
            'category' => $category,
            //'channels' => $category->with('channels')->paginate(5),
            'trending' => [],
        ]);
    }

}
