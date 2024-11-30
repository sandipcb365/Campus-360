<?php

namespace App\Http\Controllers\Dashboard\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class AdminDashboardController extends Controller {

    public function index() {
        $users = User::paginate(5);
        $showsliders = Slider::where('status', '1')->get();
        $hidesliders = Slider::where('status', '0')->get();

        $activemembers = Member::where('visibility', '1')->get();
        $inactivemembers = Member::where('visibility', '0')->get();
        return view('dashboard-admin', compact('users', 'showsliders', 'hidesliders', 'activemembers', 'inactivemembers'));
    }

    public function pageStarter() {
        return view('components.dashboard.admindashboard.sidebar.page-starter');
    }

    public function updateActiveStatus($encryptedUserId) {
        $userId = Crypt::decrypt($encryptedUserId);
        $user = User::findOrFail($userId);
        $user->update(['active_status' => $user->active_status == 1 ? 0 : 1]);
        return back()->with('status', 'active-status-updated');
    }

    public function updateStatus(Request $request) {
        $user = User::findOrFail($request->user_id);
        $user->active_status = !$user->active_status;
        $user->save();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function updateUserRole(Request $request) {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $user->role = $request->new_role;
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Role updated successfully']);
    }

    public function updateAdSlideStatus($encryptedUserId) {
        $ID = Crypt::decrypt($encryptedUserId);
        $slider = Slider::findOrFail($ID);
        $slider->update(['status' => $slider->status == 1 ? 0 : 1]);
        return back()->with('status', 'status-updated');
    }

    public function Create_slider(Request $request) {
        $slider = new slider;

        $slider->heading = $request->input('heading');
        $slider->description = $request->input('description');
        $slider->link = $request->input('link');
        $slider->link_name = $request->input('link_name');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'post_image_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $fileNameToStore);

            $slider->image = $fileNameToStore;
        }

        $slider->status = $request->input('status') == true ? '1' : '0';

        $slider->save();

        return redirect()->back()->with('success', 'Slider added successfully');
    }

    public function Edit_advertisement_slider_page($id) {
        $sliders = Slider::find($id);
        return view('components.dashboard.admindashboard.update-carousel-slide', compact('sliders'));
    }

    public function Edit_advertisement_slider(Request $request, $id) {
        $slider = Slider::find($id);

        if (!$slider) {
            return redirect()->back()->with('error', 'Slider not found');
        }

        $slider->heading = $request->input('heading');
        $slider->description = $request->input('description');
        $slider->link = $request->input('link');
        $slider->link_name = $request->input('link_name');

        if ($request->hasFile('image')) {
            $destination = 'uploads/' . $slider->image;

            if (File::exists($destination)) {
                File::delete($destination);
            }

            $image = $request->file('image');
            $fileNameToStore = 'post_image_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $fileNameToStore);

            $slider->image = $fileNameToStore;
        }

        $slider->status = $request->input('status') == true ? '1' : '0';

        $slider->save();

        return redirect()->back()->with('success', 'Slider updated successfully');
    }

    /////////////////////////////////////////////////////////////
    public function updateVisibility($encryptedUserId) {
        $ID = Crypt::decrypt($encryptedUserId);
        $member = Member::findOrFail($ID);
        $newVisibility = ($member->visibility == 1) ? 0 : 1;
        $member->update(['visibility' => $newVisibility]);
        return back()->with('status', 'Visibility-updated');
    }

    // paginaation
    public function pagination() {
        // $products = User::latest()->paginate(5);
        $users = User::paginate(5);
        return view('components.dashboard.admindashboard.paginate-users', compact('users'))->render();
    }

    public function searchUser(Request $request) {
        $users = User::where('name', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search_string . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        if ($users->count() >= 1) {
            return view('components.dashboard.admindashboard.paginate-users', compact('users'))->render();
        } else {
            return response()->JSON([
                'status' => 'nothing_found',
            ]);
        }
    }

    //
    public function Create_member(Request $request) {
        $member = new Member;

        $member->name = $request->input('name');
        $member->designation = $request->input('designation');
        $member->fb = $request->input('fb');
        $member->email = $request->input('email');
        $member->github = $request->input('github');
        $member->status = $request->input('status');
        $member->visibility = $request->input('visibility') == true ? '1' : '0';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'post_image_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $fileNameToStore);

            $member->image = $fileNameToStore;
        }

        $member->save();

        return redirect()->back()->with('success', 'Slider added successfully');
    }

    public function Edit_member_page($id) {
        $members = Member::find($id);
        return view('components.dashboard.admindashboard.update-member-slide', compact('members'));
    }
    public function Edit_member_slider(Request $request, $id) {
        $members = Member::findorfail($id);

        if (!$members) {
            return redirect()->back()->with('error', 'Slider not found');
        }

        $members->name = $request->input('name');
        $members->designation = $request->input('designation');
        $members->fb = $request->input('fb');
        $members->email = $request->input('email');
        $members->github = $request->input('github');
        $members->status = $request->input('status');
        $members->visibility = $request->input('visibility') == true ? '1' : '0';

        if ($request->hasFile('image')) {
            $destination = 'uploads/' . $members->image;

            if (File::exists($destination)) {
                File::delete($destination);
            }

            $image = $request->file('image');
            $fileNameToStore = 'post_image_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $fileNameToStore);

            $members->image = $fileNameToStore;
        }

        $members->save();

        return redirect()->back()->with('success', 'Profile Slider updated successfully');
    }
}
