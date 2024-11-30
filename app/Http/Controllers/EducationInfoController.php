<?php

namespace App\Http\Controllers;

use App\Models\EducationInfo;
use Illuminate\Http\Request;

class EducationInfoController extends Controller
{
    public function index()
    {
        return view ('education.create');
    }

    public function store_education(Request $request)
    {
        $edu = new EducationInfo;

        $edu->degree = $request->degree;
        $edu->institute = $request->institute;
        $edu->year = $request->year;

        if($edu->save()){
            return redirect('education_summary');
        }else{
            echo 'error';
        }
    }
    public function education_summary()
    {
        $edu = EducationInfo::all();
        return view ('education.index',compact('edu'));
    }
    public function edit_education($id)
    {
        $edu = EducationInfo::find($id);
        return view ('education.update',compact('edu'));
    }
    public function update_education(Request $request, $id)
    {
        $edu = EducationInfo::find($id);
        $edu->degree = $request->degree;
        $edu->institute = $request->institute;
        $edu->year = $request->year;

        if($edu->save()){
            return redirect('education_summary');
        }else{
            echo 'error';
        }

    }
}
