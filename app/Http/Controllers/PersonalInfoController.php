<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfo;
use Illuminate\Http\Request;

class PersonalInfoController extends Controller
{
    public function index()
    {
        return view('personal_info');
    }
    public function store_personal(Request $request)
    {
        $pinfo = new PersonalInfo;

        $pinfo->first_name = $request->first_name;
        $pinfo->last_name = $request->last_name;
        $pinfo->profession = $request->profession;
        $pinfo->division = $request->division;
        $pinfo->address = $request->address;
        $pinfo->website = $request->website;
        $pinfo->post_code = $request->post_code;
        $pinfo->phone = $request->phone;
        $pinfo->email = $request->email;

        if($pinfo->save()){
            return redirect('education_info');
        }else{
            echo 'error';
        }
    }
}
