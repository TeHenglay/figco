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
            'gemini_api_key' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['gemini_api_key']) && !str_contains($validated['gemini_api_key'], '•')) {
            $request->user()->update(['gemini_api_key' => $validated['gemini_api_key']]);
        } elseif ($request->input('clear_key')) {
            $request->user()->update(['gemini_api_key' => null]);
        }

        return Redirect::route('api-keys')->with('status', 'api-keys-updated');
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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
