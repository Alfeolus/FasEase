<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    // global login
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($attributes))
        {
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with([
                'success' => 'You are logged in.'
            ]);
        }

        return back()->withErrors([
            'email' => 'Email or password invalid.'
        ]);
    }

    public function tenantLinkLogin($token)
    {
        $user = User::where('login_token', $token)->firstOrFail();

        app()->instance('currentOrganization', $user->organization);

        return view('session.login-session-tenant', [
            'organization' => $user->organization,
            'user' => $user,
            'token' => $token,
        ]);
    }



    public function tenantLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token' => 'required',
        ]);

        $user = User::where('login_token', $request->token)->firstOrFail();

        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'organization_id' => $user->organization_id
        ])) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // ini ku comment krn sidebar butuh login_token, tp minusnya ga aman
        // $user->update(['login_token' => null]);

        $request->session()->regenerate();

        return redirect()->route('org.dashboard');
    }



    
    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}
