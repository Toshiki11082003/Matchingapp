<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        // Ensure the user is authenticated
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
            'profile_photo' => 'nullable|image|max:1999',
            'bio' => 'nullable|string',
        ]);

        // Fill the user data with validated data
        $user = $request->user();
        $user->fill($request->only('name', 'email', 'bio'));

        // Handle the user upload of avatar
        if ($request->hasFile('profile_photo')) {
            $filenameWithExt = $request->file('profile_photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_photo')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('profile_photo')->storeAs('public/profile_photos', $fileNameToStore);
            
            $user->profile_photo = $fileNameToStore;
        }

        // Check if the email was updated to handle verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            // additional logic to handle email verification
        }

        $user->save();

        // Redirect back with success message
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Account deleted successfully.');
    }
}
