<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use App\Http\Requests\Admin\StoreCmsPageRequest;

class CmsManagmentController extends Controller
{
    public function index() {

        $cms = Cms::all();

        return view('screens.admin.cms.pages.index');
    }

    public function create() {

        return view('screens.admin.cms.pages.create');
    }

    public function store(StoreCmsPageRequest $request) {

        Cms::create($request->sanitized());

        return back()->with('message','Page Section Created Successfully');
    }
}
