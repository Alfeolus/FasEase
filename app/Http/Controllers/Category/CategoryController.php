<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $orgId = app('currentOrganization')->id;

        $datas = Category::query()
            ->where('organization_id', $orgId)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where('name', 'like', "%$search%");
            })
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('category.category-management', compact('datas'));
    }

    
    public function create()
    {
        $organizations = Organization::all();
        return view('category.category-add', compact('organizations'));
    }

    public function store(Request $request)
    {
        // slug nya ini gausah ditampilin
        $request->validate([
            'name'=>'required|string|max:255|',
            'image'=>'nullable|image', // entar kasi gambar default
        ]);

        // generate slug
        $slug = Category::generateSlug($request->name);
        $input = $request->all();
        $input['slug'] = $slug;
        $input['organization_id'] = auth()->user()->organization_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('categories'), $filename);

            $input['image'] = 'categories/' . $filename;

        } else {
            $input['image'] = 'categories/no_image.png';
        }
        
        Category::create($input);
        session()->flash('success', 'Category has been created.');
        return redirect()->route('org.category-management-index');
    }


    public function show(Category $category)
    {
        //
    }

    public function edit($slug)
    {
        $data = Category::where('slug', $slug)->firstOrFail();
        $organizations = Organization::all();
        return view('category.category-edit', compact('data', 'organizations'));
    }

    public function update(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name'=>'required|string|max:255',
            'image'=>'nullable|image',
        ]);

        $slug_new = Category::generateSlug($request->name);

        $input = [
            'name' => $request->name,
            'slug' => $slug_new,
            'organization_id' => auth()->user()->organization_id,
        ];

        if ($request->hasFile('image')) {

            if ($category->image && $category->image !== 'categories/no_image.png') {
                $oldPath = public_path($category->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('categories'), $filename);

            $input['image'] = 'categories/' . $filename;
        }

        $category->update($input);

        session()->flash('success', 'Category has been updated.');
        return redirect()->route('org.category-management-index');
    }

    public function destroy($slug)
    {
        Category::where('slug', $slug)->delete();
        session()->flash('success', 'Category has been deleted.');
        return redirect()->route('org.category-management-index');
    }
}
