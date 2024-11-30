<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller {
    public function edit(Request $request): View {
        return view('components.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request, $encryptedId) {
        $id = decrypt($encryptedId);
        $request->validate([
            'name' => 'required|string|max:255',
            'featured_image' => 'nullable|image',
            'phone_number' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $fileNameToStore = 'post_image_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'featured_image' => $request->hasFile('featured_image') ? $fileNameToStore : $user->featured_image,
            'mobile' => $request->phone_number,
            'facebook' => $request->facebook,
            'telegram' => $request->telegram,
            'github' => $request->github,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->delete()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->to('home')->with('delete_account_status', 'Account deleted successfully.');
        } else {
            return redirect()->back('')->with('delete_account_error', 'Failed to delete account. Please try again.');
        }
    }
}
