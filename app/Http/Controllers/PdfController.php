<?php

namespace App\Http\Controllers;

use App\Models\CertificateInfo;
use App\Models\ObjectiveInfo;
use App\Models\PersonalInfo;
use App\Models\WorkInfo;
use App\Models\EducationInfo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class PdfController extends Controller
{
    public function index()
    {
        $data= array();

        $data['personalInfo'] = PersonalInfo::first();
        $data['objective'] = ObjectiveInfo::first();
        $data['education'] = EducationInfo::first();
        $data['work'] = WorkInfo::first();
        $data['cetificate'] = CertificateInfo::first();


        return view('pdf',compact('data'));
    }
    public function download()
    {
        $data= array();

        $data['personalInfo'] = PersonalInfo::first();
        $data['objective'] = ObjectiveInfo::first();
        $data['education'] = EducationInfo::first();
        $data['work'] = WorkInfo::first();
        $data['cetificate'] = CertificateInfo::first();

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf',compact('data'));
        return $pdf->download('myresume.pdf');
    }
}
