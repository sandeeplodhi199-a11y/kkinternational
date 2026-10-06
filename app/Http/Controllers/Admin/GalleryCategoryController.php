<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $data['menu'] = 'gallery';
        $data['submenu'] = 'gallery_category';
        $categories = GalleryCategory::where('is_deleted', 0)->orderByDesc('id')->paginate(20);
        return view('backend.gallery_categories.index', compact('data', 'categories'));
    }

    public function add()
    {
        $data['menu'] = 'gallery';
        $data['submenu'] = 'gallery_category';
        return view('backend.gallery_categories.add', compact('data'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
        $slug = $this->uniqueSlug($request->name);
        GalleryCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $this->uploadImage($request),
            'status' => $request->status ?? 'Active',
            'is_deleted' => 0,
        ]);
        return redirect('admin/gallery-categories')->with('success', 'Gallery Category saved successfully.');
    }

    public function edit($id)
    {
        $data['menu'] = 'gallery';
        $data['submenu'] = 'gallery_category';
        $category = GalleryCategory::findOrFail($id);
        return view('backend.gallery_categories.edit', compact('data', 'category'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
        $category = GalleryCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->slug = $this->uniqueSlug($request->name, $category->id);
        $image = $this->uploadImage($request);
        if ($image) {
            $category->image = $image;
        }
        $category->status = $request->status ?? 'Active';
        $category->save();
        return redirect('admin/gallery-categories')->with('success', 'Gallery Category updated successfully.');
    }

    public function delete($id)
    {
        $category = GalleryCategory::findOrFail($id);
        $category->is_deleted = 1;
        $category->save();
        return redirect()->back()->with('success', 'Gallery Category deleted successfully.');
    }

    private function uniqueSlug($name, $ignoreId = null)
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (GalleryCategory::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $filename = date('YmdHi') . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        return $filename;
    }
}
