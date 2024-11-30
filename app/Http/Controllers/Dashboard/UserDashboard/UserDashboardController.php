<?php

namespace App\Http\Controllers\Dashboard\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller {
    public function UserDashboardPage() {
        $users = User::all();

        // if (Auth::user()->role === 'admin') {
        //     return redirect()->route('dashboard.admin');
        // }
        return view('dashboard-user', compact('users'));
    }
}
