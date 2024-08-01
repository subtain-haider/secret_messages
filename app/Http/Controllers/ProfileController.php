<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Session;
use Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        Session::flash('success_message', 'Profile Updated');
        return redirect()->back();
    }

     /**
     * Update the user's profile information.
     */
    public function password(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $data = $request->validated();


        if (!Hash::check($data['current_password'], $user->password)) {
            Session::flash('error_message', 'The current password does not match our records.');
            return back();
        }

        // Update the user's password
        $user->password = $data['current_password'];
        $user->save();
        Session::flash('success_message', 'Password Updated');
        return redirect()->back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
