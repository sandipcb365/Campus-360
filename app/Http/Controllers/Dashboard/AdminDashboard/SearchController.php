<?php

namespace App\Http\Controllers\Dashboard\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller {
    public function index(Request $request) {
        $perPage = $request->perPage ?? 5;
        $keyword = $request->keyword;

        $query = User::query();

        if ($keyword) {
            $query = $query->where('email', 'like', '%' . $keyword . '%');
            // $query->orWhere('email', 'like', '%' . $keyword . '%');
        }

        return $query->orderByDesc('id')->paginate($perPage)->withQueryString();
    }
}
