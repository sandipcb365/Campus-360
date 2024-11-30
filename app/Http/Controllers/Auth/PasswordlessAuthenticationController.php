<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PasswordlessAuthenticationController extends Controller {

    public function sendLink(Request $request): RedirectResponse {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $url = URL::temporarySignedRoute(
            'passwordless.authenticate', now()->addMinutes(30), ['user' => $user->id]
        );

        Mail::to($request->email)->send(new SendMail($url));

        return back()->with('success', 'A link has been sent to your email address. Please click the link to login');
    }

    public function authenticateUser(Request $request): RedirectResponse {
        $user = User::findOrFail($request->user);

        if (!URL::hasValidSignature($request)) {
            return redirect('/login')->withErrors(['url' => 'The link is invalid.']);
        }

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect('/login');
    }
}
