<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed', 'alpha_num'],
        ],
        [
            'current_password.required'         => '現在のパスワードを入力してください。',
            'current_password.current_password' => '現在のパスワードが間違っています。',
            'password.required'                 => '新しいパスワードを入力してください。',
            'password.min'                      => 'パスワードは :min 文字以上で設定してください。',
            'password.alpha_num'                => 'パスワードは英数字のみで設定してください。',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
