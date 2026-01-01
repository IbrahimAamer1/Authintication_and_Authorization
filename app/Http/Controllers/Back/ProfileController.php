<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class ProfileController extends Controller
{
    const DIRECTORY = 'back.profile';

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = Auth::guard('admin')->user();
        return view(self::DIRECTORY . ".edit", \get_defined_vars())
            ->with('directory', self::DIRECTORY);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request)
    {
        /** @var \App\Models\Admin $user */
        $user = Auth::guard('admin')->user();
        
        $user->fill($request->validated());

        // If email is changed, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route(self::DIRECTORY . '.edit')
            ->with('success', __('lang.profile_updated') ?? 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        /** @var \App\Models\Admin $user */
        $user = Auth::guard('admin')->user();
        
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route(self::DIRECTORY . '.edit')
            ->with('success', __('lang.password_updated') ?? 'Password updated successfully.');
    }
   
}
