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

        if (Auth::attempt(array_merge($attributes, ['is_active' => 1]))) {
            $user = Auth::user();

            if ($user->role !== 'superadmin') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'You are not authorized to access this area.'
                ]);
            }

            $request->session()->regenerate();
            session([
                'login_type' => 'superadmin'
            ]);

            return redirect()->route('dashboard')->with([
                'success' => 'You are logged in as Super Admin.'
            ]);
        }

        return back()->withErrors([
            'email' => 'Email or password invalid or account is inactive.'
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
            'organization_id' => $user->organization_id,
            'is_active' => 1
        ])) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // ini ku comment krn sidebar butuh login_token, tp minusnya ga aman
        // $user->update(['login_token' => null]);

        $request->session()->regenerate();
        session([
            'login_type' => 'tenant',
            'organization_id' => $user->organization_id,
            'login_token' => $request->token
        ]);

        return redirect()->route('org.dashboard');
    }



    
    public function destroy(Request $request)
    {
        $loginType = session('login_type');

        // ambil login_token sebelum logout
        $loginToken = session('login_token');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($loginType === 'tenant') {
            // tenant logout
            return redirect('/login/organization/' . $loginToken)
                ->with('success', 'You have been logged out.');
        }

        // superadmin logout (default)
        return redirect()
            ->route('login-superadmin-index')
            ->with('success', 'You have been logged out.');
    }

}
