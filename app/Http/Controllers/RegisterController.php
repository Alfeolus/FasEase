<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'phone' => ['required', 'max:15'],
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );
        // $attributes['role'] = 'superadmin';
        // $attributes['organization_id'] = 1;

        $user = User::create($attributes);

        session()->flash('success', 'Your account has been created.');
        return redirect()->route('dashboard');
    }
}
