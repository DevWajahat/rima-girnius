<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    //
    public function index() {

        return view('screens.web.blogs.index');
    }
}
