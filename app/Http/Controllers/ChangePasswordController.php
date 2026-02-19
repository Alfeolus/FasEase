<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $redirectRoute = 'login';

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:20', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) use (&$redirectRoute) {

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));

                if ($user->role === 'superadmin') {
                    $redirectRoute = 'login-superadmin-index';
                } else {
                    $orgToken = optional($user->organization)->token;

                    $redirectRoute = route(
                        'organization.login.link',
                        $orgToken
                    );
                }
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->to($redirectRoute)
                ->with('success', __($status))
            : back()->withErrors([
                'email' => [__($status)]
            ]);
    }
}
