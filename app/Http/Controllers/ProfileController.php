<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function apiKeys(Request $request): View
    {
        return view('api-keys', ['user' => $request->user()]);
    }

    public function updateApiKeys(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'figma_access_token' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['figma_access_token']) && !str_contains($validated['figma_access_token'], '•')) {
            $request->user()->update(['figma_access_token' => $validated['figma_access_token']]);
        } elseif ($request->input('clear_figma_token')) {
            $request->user()->update(['figma_access_token' => null]);
        }

        return Redirect::route('api-keys')->with('status', 'api-keys-updated');
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
        $validated = $request->validated();

        // Only update figma_access_token when a real token is submitted
        if (empty($validated['figma_access_token']) || str_contains($validated['figma_access_token'], '•')) {
            unset($validated['figma_access_token']);
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
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
