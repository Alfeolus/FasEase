<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $datas = User::query()
            ->whereKeyNot(auth()->id())
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(50)
            ->withQueryString();

        return view('user.user-management', compact('datas'));
    }


    public function create()
    {
        $organizations = Organization::all();
        return view('user.user-add', compact('organizations'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:20'],
            'phone' => ['required', 'max:15'],
            'role' => ['required'],
            'organization_id' => ['required'],
            'is_active' => ['required'],
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );
        // $attributes['role'] = 'superadmin';
        // $attributes['organization_id'] = 1;

        $attributes['login_token'] = Str::random(40);

        session()->flash('success', 'User account has been created.');
        $user = User::create($attributes);

        return redirect('user-management');
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $organizations = Organization::all();
        return view('user.user-edit', compact('data', 'organizations'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'max:15'],
            'password' => ['nullable', 'required', 'min:8', 'max:20'],
            'role' => ['required'],
            'organization_id' => ['required'],
            'is_active' => ['required'],
        ]);

        if (empty($attributes['password'])) {
            unset($attributes['password']);
        } else {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        $user->update($attributes);

        session()->flash('success', 'User account has been updated.');
        return redirect('user-management');
    }   

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User account has been deleted.');
        return redirect('user-management');
    }
}
