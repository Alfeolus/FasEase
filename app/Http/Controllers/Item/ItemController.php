<?php

namespace App\Http\Controllers\Item;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request){
        $orgId = app('currentOrganization')->id;

        $datas = Item::query()
            ->where('organization_id', $orgId)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where('name', 'like', "%$search%");
            })
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('item.item-management', compact('datas'));
    }

    public function create(){
        $categories = Category::where('organization_id', app('currentOrganization')->id)->get();
        return view('item.item-add', compact('categories', ));
    }

    public function generateBookingSlot(Item $item)
    {
        $slots = [];
        $start = Carbon::parse($item->opening_time);
        $end = Carbon::parse($item->closing_time);
        $duration = $item->max_book_duration;

        while ($start->copy()->addHours($duration) <= $end) {

            $slotStart = $start->copy();
            $slotEnd = $start->copy()->addHours($duration);

            $slots[] = [
                'start' => $slotStart->format('H:i'),
                'end' => $slotEnd->format('H:i'),
            ];

            $start->addHours($duration);
        }

        return $slots;
    }

    public function store(Request $request){
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255|',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
            'max_book_duration' => 'required|integer|min:1',
        ]);

        $slug = Item::generateSlug($request->name);
        $input = $request->all();
        $input['slug'] = $slug;
        $input['is_active'] = $request->is_active;  
        $input['organization_id'] = auth()->user()->organization_id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store(
                'categories',   
                'public'        
            );
            $input['image'] = 'storage/' . $path;

        } else {
            $input['image'] = 'storage/no_image.png';
        }

        Item::create($input);
        session()->flash('success', 'Item has been created.');
        return redirect()->route('org.item-management-index');
    }

    public function edit($slug){
        $data = Item::where('slug', $slug)->first();
        $categories = Category::where('organization_id', app('currentOrganization')->id)->get();
        return view('item.item-edit', compact('data', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $item = Item::where('slug', $slug)
            ->where('organization_id', auth()->user()->organization_id)
            ->firstOrFail();

        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
            'max_book_duration' => 'required|integer|min:1',
        ]);

        $input = [
            'name' => $request->name,
            'slug' => Item::generateSlug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'max_book_duration' => $request->max_book_duration,
            'is_active' => $request->is_active,
            'organization_id' => auth()->user()->organization_id,
        ];

        if ($request->hasFile('image')) {
            if ($item->image && $item->image !== 'storage/no_image.png') {
                $oldPath = str_replace('storage/', '', $item->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('items', 'public');
            $input['image'] = 'storage/' . $path;
        }

        $item->update($input);

        return redirect()->route('org.item-management-index')
            ->with('success', 'Item has been updated.');
    }

    public function destroy($slug)
    {
        Item::where('slug', $slug)->delete();
        session()->flash('success', 'Item has been deleted.');
        return redirect()->route('org.item-management-index');
    }
}
