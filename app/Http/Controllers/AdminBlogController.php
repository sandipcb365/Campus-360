<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminBlog;
use App\Models\UserBlog;
use Illuminate\Support\Facades\Auth;

class AdminBlogController extends Controller
{
    public function add_blog()
    {
        return view('components.dashboard.admindashboard.blog.adminblog');
    }
    public function post_blog(Request $request)
    {
       $user = Auth()->user();
       $user_id = $user->id;
       $name = $user->name;
       $usertype = $user->usertype;

       $post = new AdminBlog;
       $post->title = $request->title;
       $post->description = $request->description;
       $post->post_status = 'active';
       $post->user_id = $user_id;
       $post->name = $name;
       $post->usertype = $usertype;

       $image=$request->image;
       $imagename=time().'.'.$image->getClientOriginalExtension();
       $request->image->move('blogimage',$imagename);

       $post->image=$imagename;


       $post->save();
       return redirect()->back()->with('message','Blog uploaded Succesfully');
    }
    public function show_blog()
    {
        $post = AdminBlog::all();
        return view('components.dashboard.admindashboard.blog.adminShowblog',compact('post'));
    }

    public function manage_user_blog()
    {
        $userblog = UserBlog::all();
        return view('components.dashboard.admindashboard.blog.mange_user_blog',compact('userblog'));
    }


    public function delete_blog($id)
    {
       $post = AdminBlog::find($id);
       $post->delete();

       return redirect()->back()->with('message','Post Deleted Succesfully');

    }
    public function  delete_user_blog($id)
    {
       $userblog = UserBlog::find($id);
       $userblog->delete();
       return redirect()->back()->with('message','Post Deleted Succesfully');

    }

    public function edit_blog($id)
    {
        $post = AdminBlog::find($id);

        return view('components.dashboard.admindashboard.blog.adminEditblog',compact('post'));

    }
    public function update_blog(Request $request,$id)
    {
        $data = AdminBlog::find($id);

       $data->title = $request->title;
       $data->description = $request->description;
       $image=$request->image;

       if($image)
      {
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('blogimage',$imagename);

        $data->image=$imagename;
      }

       $data->save();
       return redirect()->back()->with('message','Blog Updateted Succesfully');
    }
    public function accept_blog($id)
    {
        $userpost = UserBlog::find($id);
        $userpost->post_status='active';
        $userpost->save();

        return redirect()->back()->with('message','One User Post Uploaded Succesfully');

    }
    public function reject_blog($id)
    {
        $userpost = UserBlog::find($id);
        $userpost->post_status='rejected';
        $userpost->save();

        return redirect()->back()->with('message','One User Post Rejected');

    }
    public function manage_blog_sidebar()
    {
        return view('components.dashboard.admindashboard.manage_blog_sidebar');
    }
}
