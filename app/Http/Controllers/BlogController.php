<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminBlog;
use App\Models\UserBlog;


class BlogController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
    }
    public function index() {
        $post = AdminBlog::all();
        $userblog = UserBlog::where('post_status','=','active')->get();
        return view('blog',compact('post','userblog'));
    }

    public function post_details($id)
    {
        $post = AdminBlog::find($id);

        return view('components.post_details',compact('post'));

    }
    public function user_blog_details($id)
    {

        $userblog = UserBlog::find($id);
        return view('components.user_blog_details',compact('userblog'));

    }
    public function create()
    {
        return view('components.post');
    }



}
