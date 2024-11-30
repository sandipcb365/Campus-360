<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Paid_course;

class JobController extends Controller {
    public function index() {
        $paid_courses = Paid_course::all();
        return view('job', compact('paid_courses'));
    }
}
