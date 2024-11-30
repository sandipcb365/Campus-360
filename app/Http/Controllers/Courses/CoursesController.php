<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;

class CoursesController extends Controller {
    public function CoursePage() {
        return view('course');
    }

    public function AIPage() {
        // return view('courses.ai');
        $courseName = 'ai';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.ai', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function algoPage() {
        // return view('courses.algo');
        $courseName = 'algorithm';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.algo', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    // c
    public function CPage() {
        // return view('courses.c');
        $courseName = 'cpage';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.c', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    //c++
    public function C_Page() {
        // return view('courses.c++');
        $courseName = 'c_page';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.c++', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function DEPage() {
        // return view('courses.de');
        $courseName = 'de';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.de', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function DSPage() {
        // return view('courses.ds');
        $courseName = 'ds';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.ds', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function HTMLPage() {
        // return view('courses.html');
        $courseName = 'html';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.html', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function JavaPage() {
        // return view('courses.java');
        $courseName = 'java';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.java', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function JSPage() {
        // return view('courses.js');
        $courseName = 'js';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.js', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function microPage() {
        // return view('courses.micro');
        $courseName = 'micro';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.micro', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function mlPage() {
        // return view('courses.ml');
        $courseName = 'ml';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.ml', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function MySqlPage() {
        // return view('courses.mysql');
        $courseName = 'mysql';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.mysql', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function OOPPage() {
        // return view('courses.oop');
        $courseName = 'oop';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.oop', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function PHPPage() {
        // return view('courses.php');
        $courseName = 'php';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.php', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function PythonPage() {
        // return view('python');
        $courseName = 'pyhton';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.python', compact('courseName', 'types', 'yt_links', 'set_types'));
    }
    public function ReactPage() {
        // return view('courses.react');
        $courseName = 'react';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.react', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

    public function VLSIPage() {
        // return view('courses.vlsi');
        $courseName = 'vlsi';
        $types = ['youtube', 'websites', 'paid_courses', 'lu'];
        $yt_links = ["youtube_link_1", "youtube_link_2", "youtube_link_3", "youtube_link_4"];
        $set_types = ['YouTube Link', 'WebsiteLink', 'Paid Courses Link', 'LU'];
        return view('components.courses.vlsi', compact('courseName', 'types', 'yt_links', 'set_types'));
    }

}
