<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserBlog;
use Illuminate\Support\Facades\Auth;

class UserBlogController extends Controller
{
    public function useradd_blog()
    {
        return view('components.dashboard.userdashboard.blog.user-add-blog');
    }
    public function userpost_blog(Request $request)
    {
       $user = Auth()->user();
       $user_id = $user->id;
       $name = $user->name;
       $usertype = $user->usertype;

       $userblog = new UserBlog();
       $userblog->title = $request->title;
       $userblog->description = $request->description;
       $userblog->post_status = 'pending';
       $userblog->user_id = $user_id;
       $userblog->name = $name;


       $image=$request->image;
       $imagename=time().'.'.$image->getClientOriginalExtension();
       $request->image->move('blogimage',$imagename);

       $userblog->image=$imagename;


       $userblog->save();
       return redirect()->back()->with('message','Blog uploaded Succesfully');

    }
    public function usershow_blog()
    {
        $user=Auth::user();
        $userid = $user->id;
        $userblog = UserBlog::where('user_id','=',$userid)->get();
        return view('components.dashboard.userdashboard.blog.user-show-blog',compact('userblog'));
    }
    public function user_delete_blog($id)
    {
       $userblog = UserBlog::find($id);
       $userblog->delete();
       return redirect()->back()->with('message','Post Deleted Succesfully');

    }
    public function user_edit_blog($id)
    {
        $userblog = userblog::find($id);

        return view('components.dashboard.userdashboard.blog.user-edit-blog',compact('userblog'));

    }
    public function userupdate_blog(Request $request,$id)
    {
        $data = userblog::find($id);

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

}
