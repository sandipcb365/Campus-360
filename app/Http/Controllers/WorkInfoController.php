<?php

namespace App\Http\Controllers;

use App\Models\WorkInfo;
use Illuminate\Http\Request;

class WorkInfoController extends Controller
{
    public function index()
    {
        return view('work_exp.create');
    }
    public function store_work(Request $request)
    {
        $work = new WorkInfo;

        $work->company_name = $request->company_name;
        $work->position = $request->position;
        $work->year = $request->year;

        if($work->save()){
            return redirect('summary_work');
        }else{
            echo 'error';
        }
    }
    public function summary_work()
    {
        $work = WorkInfo::all();
        return view('work_exp.index',compact('work'));
    }
    public function edit_work($id)
    {
        $work = WorkInfo::find($id);
        return view ('work_exp.update',compact('work'));
    }
    public function update_work(Request $request, $id)
    {
        $work = WorkInfo::find($id);
        $work->company_name = $request->company_name;
        $work->position = $request->position;
        $work->year = $request->year;

        if($work->save()){
            return redirect('summary_work');
        }else{
            echo 'error';
        }

    }

}
