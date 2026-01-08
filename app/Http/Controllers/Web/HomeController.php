<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class HomeController extends Controller
{
    public function index()
    {


        $posts = Post::limit(3)->get();

        return view('screens.web.index',get_defined_vars());
    }
}
