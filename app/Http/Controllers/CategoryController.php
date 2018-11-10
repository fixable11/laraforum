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
            'category' => $category,
            //'channels' => $category->with('channels')->paginate(5),
            'trending' => [],
        ]);
    }

}
