<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class BlogsController extends Controller
{
    //
    public function index() {

        $posts = Post::all();

        return view('screens.web.blogs.index',get_defined_vars());
    }


    public function show($id)
    {


        $post = Post::find($id);

        return view('screens.web.blogs.show',get_defined_vars());
    }
}
