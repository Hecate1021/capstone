<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Image;
use App\Models\TemporyImage;
use App\Models\UserInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contactNo' => 'required|digits_between:1,13',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ];
    }
    public function edit(Request $request): View
    {

        $user = auth()->user();

        $userInfo = $user->userInfo; // Assuming a one-to-one relationship

        return view('profile.edit', compact('user', 'userInfo'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    UserInfo::updateOrCreate(
        ['user_id' => $user->id],
        [
            'user_id' => $user->id,
            'contactNo' => $request->input('contactNo'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
        ]
    );

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

    public function profilePhoto(Request $request)
    {
        $user = $request->user();
        $userInfo = UserInfo::where('user_id', $user->id)->first();

        if ($userInfo && $userInfo->profilePath) {
            // Delete the old profile photo from storage

            Storage::delete('images/' . $userInfo->profilePath);

            // Delete the directory if it is empty
            $folderPath = dirname('images/' . $userInfo->profilePath);
            if (count(Storage::files($folderPath)) === 0) {
                Storage::deleteDirectory($folderPath);
            }
        }
        $temporaryImages = TemporyImage::all();
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temporary storage to the final location
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            // Create a new image record
            UserInfo::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profilePhoto' => $temporaryImage->file,
                    'profilePath' => $temporaryImage->folder . '/' . $temporaryImage->file,
                ]
            );

            // Cleanup the temporary directory and delete the temporary image record
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function coverPhoto(Request $request)
    {
        $user = $request->user();
        $userInfo = UserInfo::where('user_id', $user->id)->first();

        if ($userInfo && $userInfo->coverPath) {
            // Delete the old profile photo from storage

            Storage::delete('images/' . $userInfo->coverPath);

            // Delete the directory if it is empty
            $folderPath = dirname('images/' . $userInfo->coverPath);
            if (count(Storage::files($folderPath)) === 0) {
                Storage::deleteDirectory($folderPath);
            }
        }
        $temporaryImages = TemporyImage::all();
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temporary storage to the final location
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            // Create a new image record
            UserInfo::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'coverPhoto' => $temporaryImage->file,
                    'coverPath' => $temporaryImage->folder . '/' . $temporaryImage->file,
                ]
            );

            // Cleanup the temporary directory and delete the temporary image record
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
