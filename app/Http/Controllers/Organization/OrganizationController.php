<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $datas = Organization::query()
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->search;

            $query->where('name', 'like', "%$search%");
        })
        ->latest()
        ->paginate(50)
        ->withQueryString();

        return view('organization.organization-management', compact('datas'));
    }

    public function create()
    {
        return view('organization.organization-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $slug_new = Organization::generateSlug($request->name);
        $input = $request->only(['name', 'email', 'phone', 'location']);
        $input['slug'] = $slug_new;
        $input['token'] = Str::random(40);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $destinationPath = 'images/categories/';
            $image->move(public_path($destinationPath), $profileImage);
            $input['image'] = $destinationPath . $profileImage;
        } else {
            // default image
            $input['image'] = 'storage/no_image.png';
        }


        Organization::create($input);
        session()->flash('success', 'Organization has been created.');
        return redirect('organization-management');
    }

    public function edit($slug)
    {
        $data = Organization::where('slug', $slug)->firstOrFail();
        return view('organization.organization-edit', compact('data'));
    }   

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $slug_new = Organization::generateSlug($request->name);
        $input = $request->only(['name', 'email', 'phone', 'location']);
        $input['slug'] = $slug_new;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $destinationPath = 'images/categories/';
            $image->move(public_path($destinationPath), $profileImage);
            $input['image'] = $destinationPath . $profileImage;
        } 

        Organization::where('slug', $slug)->update($input);
        session()->flash('success', 'Organization has been updated.');
        return redirect('organization-management');
    }

    public function destroy($slug)
    {
        Organization::where('slug', $slug)->delete();
        session()->flash('success', 'Organization has been deleted.');
        return redirect('organization-management');
    }
}
