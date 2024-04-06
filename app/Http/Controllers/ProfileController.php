<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // dd($request->user());
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd($request->email);
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        $data = User::find(auth()->id());
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->designation = $request->designation;
        if ($request->photo) {

            $imageFile = $request->file('photo');

            // Generate a unique filename
            $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();

            // Move the uploaded file to a storage directory
            $imagePath = $imageFile->storeAs('images', $filename, 'public');

            $image = ImageManager::imagick()->read($request->photo);
            $image->resize(300, 200);
            $image->save();

            $data->photo =  $imagePath;
        }
        $data->update();


        //$request->user()->save();

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
