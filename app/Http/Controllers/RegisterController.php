<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function create_organization($token)
    {
        $organization = Organization::where('token', $token)->firstOrFail();
        return view('session.register-tenant', compact('organization'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:20'],
            'phone' => ['required', 'max:15'],
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );
        $attributes['role'] = 'superadmin';
        $attributes['organization_id'] = 1;

        $user = User::create($attributes);

        $request->session()->regenerate();
        session([
            'login_type' => 'superadmin'
        ]);

        $user->login_at = now();
        $user->save();
        
        session()->flash('success', 'Your account has been created.');
        return redirect()->route('superadmin.dashboard');
    }

    public function store_organization(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:20'],
            'phone' => ['required', 'max:15'],
        ]);

        $token = Str::random(10); 
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => 'user', 
            'organization_id' => $request->organization_id, 
            'is_active' => 1
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        session([
            'login_type' => 'tenant', 
            'organization_id' => $user->organization_id, 
            'login_token' => $request->organization_token
        ]);

        $user->login_at = now();
        $user->save();

        session()->flash('success', 'Account created and logged in successfully.');

        if($user->role == 'admin'){
            return redirect()->route('org.dashboard-admin');
        } else {
            return redirect()->route('org.dashboard-user');
        }
    }
}
