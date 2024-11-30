<?php

namespace App\Http\Controllers;
use App\Models\Module;
use App\Models\Paid_course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CourseController extends Controller {
    public function index() {
        $paid_courses = Paid_course::all();
        // $paid_courses = Paid_course::with('modules')->get();
        return view('job', compact('paid_courses'));
    }

    public function store(Request $request) {
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

    public function showPaidCourse($encryptedId) {
        $id = Crypt::decrypt($encryptedId);
        $paid_course = Paid_course::findOrFail($id);
        $modules = $paid_course->modules;
        return view('components.job.paid-course', compact('paid_course', 'modules', 'encryptedId'));
    }

    public function showModule($courseName, $moduleNumber, $encryptedModuleId) {
        $moduleId = Crypt::decrypt($encryptedModuleId);
        $module = Module::findOrFail($moduleId);
        // $module = Module::findOrFail($encryptedModuleId);
        $paid_course = $module->paidCourse; // Relationship set up in the Module model

        return view('components.job.module', compact('module', 'paid_course'));
    }

    public function storeModule(Request $request, $encryptedId) {
        $id = Crypt::decrypt($encryptedId);
        // $paid_course = Paid_course::findOrFail($id);

        $paid_course = Paid_course::findOrFail(Crypt::decrypt($encryptedId));

        $moduleNumber = $paid_course->modules()->count() + 1; // Increment module number

        Module::create([
            'paid_course_id' => $paid_course->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'module_number' => $moduleNumber,
        ]);

        return redirect()->route('job_preparation.show', $encryptedId)->with('success', 'Module added successfully!');
    }
}
