<?php

namespace App\Http\Controllers;

use App\Models\ObjectiveInfo;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function index()
    {
        return view ('objective.create');
    }

    public function store_objective(Request $request)
    {
        $obj = new ObjectiveInfo;

        $obj->career_object = $request->career_object;

        if($obj->save()){
            return redirect('summary_objective');
        }else{
            echo 'error';
        }
    }
    public function summary_objective()
    {
        $obj = ObjectiveInfo::first();
        return view ('objective.index',compact('obj'));
    }
    public function edit_objective($id)
    {
        $obj = ObjectiveInfo::find($id);
        return view ('objective.update',compact('obj'));
    }
    public function update_objective(Request $request, $id)
    {
        $obj = ObjectiveInfo::find($id);
        $obj->career_object = $request->career_object;

      if($obj->save()){
            return redirect('summary_objective');
        }else{
            echo 'error';
        }
    }
}
