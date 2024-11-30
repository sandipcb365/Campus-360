<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Paid_course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PaidCourseController extends Controller {
    public function storePaidCourse(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $fileNameToStore = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'paid_course_image_' . md5(uniqid()) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }
        Paid_course::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $request->hasFile('image') ? $fileNameToStore : '',
        ]);
        return redirect()->route('job_preparation')->with('success', 'Course created successfully!');
    }

    public function updatepaidCourse(Request $request, $encryptedId) {
        $id = Crypt::decrypt($encryptedId);
        $paid_course = Paid_course::findOrFail($id);
        $modules = $paid_course->modules;

        $fileNameToStore = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'paid_course_image_' . md5(uniqid()) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }

        $paid_course->title = $request->input('title');
        $paid_course->description = $request->input('description');
        $paid_course->image = $request->hasFile('image') ? $fileNameToStore : '';

        $paid_course->save();

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function showPaidCourse($encryptedId) {
        $id = Crypt::decrypt($encryptedId);
        $paid_course = Paid_course::findOrFail($id);
        $modules = $paid_course->modules;
        return view('components.job.paid-course', compact('paid_course', 'modules', 'encryptedId'));
    }
}
