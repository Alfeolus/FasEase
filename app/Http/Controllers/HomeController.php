<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return redirect('dashboard');
    }

    public function home_tenant()
    {
        $user = auth()->user();

        if (!$user || !$user->organization) {
            abort(403, 'Organization not found.');
        }

        return view('dashboard', [
            'organization' => $user->organization
        ]);
    }

}
