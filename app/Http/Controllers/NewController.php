<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NewController extends Controller {
    public function updateStatus(Request $request) {
        $user = User::findOrFail($request->user_id);
        $user->active_status = !$user->active_status;
        $user->save();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
