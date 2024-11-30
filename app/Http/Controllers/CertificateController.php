<?php

namespace App\Http\Controllers;

use App\Models\CertificateInfo;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        return view ('certificate.create');
    }
    public function store_certificate(Request $request)
    {
        $cer = new CertificateInfo;

        $cer->certificate_name = $request->certificate_name;
        $cer->about = $request->about;
        $cer->year = $request->year;

        if($cer->save()){
            return redirect('summary_certificate');
        }else{
            echo 'error';
        }
    }
    public function summary_certificate()
    {
        $cer = CertificateInfo::all();
        return view ('certificate.index',compact('cer'));
    }
    public function edit_certificate($id)
    {
        $cer = CertificateInfo::find($id);
        return view ('certificate.update',compact('cer'));
    }
    public function update_certificate(Request $request, $id)
    {
        $cer = CertificateInfo::find($id);
        $cer->certificate_name = $request->certificate_name;
        $cer->about = $request->about;
        $cer->year = $request->year;

        if($cer->save()){
            return redirect('summary_certificate');
        }else{
            echo 'error';
        }
    }
}
