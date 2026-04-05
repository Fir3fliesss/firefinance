<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'position' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'line_manager' => ['nullable', 'string', 'max:100'],
        ];

        // Jika bukan login google, boleh update email, password, dan foto
        if (!$user->google_id) {
            $rules['email'] = [
                'required', 'string', 'email', 'max:255', 
                Rule::unique('users')->ignore($user->id)
            ];
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
            $rules['avatar_file'] = ['nullable', 'image', 'max:2048'];
        }

        $validated = $request->validate($rules);

        if (!$user->google_id) {
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            if ($request->hasFile('avatar_file')) {
                // Hapus avatar lama bila ada dan bukan url publik Google
                if ($user->avatar && !Str::startsWith($user->avatar, 'http')) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $path = $request->file('avatar_file')->store('avatars', 'public');
                $validated['avatar'] = $path;
            }
        } else {
            // Pengamanan tambahan
            unset($validated['email']);
            unset($validated['password']);
        }

        // Hapus file dari validated array agar tidak bermasalah dengan query sql mass-assignment
        unset($validated['avatar_file']);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
