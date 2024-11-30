<?php

namespace App\Http\Controllers;
use App\Models\member;
use App\Models\slider;

class MainController extends Controller {
    public function HomePage() {
        $sliders = Slider::where('status', '1')->get();
        $members = Member::where('visibility', 1)
            ->orderByRaw("FIELD(status, 'Supervisor', 'Member')")
            ->get();
        return view('home', compact('sliders', 'members'));
    }

   /* public function BlogPage() {
        return view('blog');
    }
    */

    public function Load_MorePage() {
        return view('Components.load-more');
    }

    public function ConstructionSmsPage() {
        return view('components.construction-sms');
    }

    public function AboutUs() {
        return view('about_us_index');
    }
}
