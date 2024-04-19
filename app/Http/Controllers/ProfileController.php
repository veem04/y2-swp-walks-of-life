<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Storage;

class ProfileController extends Controller
{
    public function show($id): View
    {
        $user = User::findOrFail($id);
        $journeys = $user->journeys()->orderBy('created_at', 'desc')->paginate(8);
        return view('profile.show', [
            'user' => $user,
            'journeys' => $journeys,
        ]);
    }

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
        $oldImage = $request->user()->image;
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // code for image upload
        if ($request->image) {
            // deletes the existing image
            if(Storage::exists('public/images/'.$oldImage) && $oldImage !== "cover.png"){
                Storage::delete('public/images/'.$oldImage);
            }
            // image name is the timestamp + the provided file extension
            $imageName = time().'.'.$request->image->extension();
            // stores the file in public/images as the image name
            Storage::putFileAs('public/images', $request->image,  $imageName);
            $request->user()->image = $imageName;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
