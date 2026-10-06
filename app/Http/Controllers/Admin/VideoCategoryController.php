<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoCategoryController extends Controller
{
    public function index()
    {
        $data['menu'] = 'video';
        $data['submenu'] = 'video_category';
        $categories = VideoCategory::where('is_deleted', 0)->orderByDesc('id')->paginate(20);
        return view('backend.video_categories.index', compact('data', 'categories'));
    }

    public function add()
    {
        $data['menu'] = 'video';
        $data['submenu'] = 'video_category';
        return view('backend.video_categories.add', compact('data'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
        VideoCategory::create([
            'name' => $request->name,
            'slug' => $this->uniqueSlug($request->name),
            'image' => $this->uploadImage($request),
            'status' => $request->status ?? 'Active',
            'is_deleted' => 0,
        ]);
        return redirect('admin/video-categories')->with('success', 'Video Category saved successfully.');
    }

    public function edit($id)
    {
        $data['menu'] = 'video';
        $data['submenu'] = 'video_category';
        $category = VideoCategory::findOrFail($id);
        return view('backend.video_categories.edit', compact('data', 'category'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
        $category = VideoCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->slug = $this->uniqueSlug($request->name, $category->id);
        $image = $this->uploadImage($request);
        if ($image) {
            $category->image = $image;
        }
        $category->status = $request->status ?? 'Active';
        $category->save();
        return redirect('admin/video-categories')->with('success', 'Video Category updated successfully.');
    }

    public function delete($id)
    {
        $category = VideoCategory::findOrFail($id);
        $category->is_deleted = 1;
        $category->save();
        return redirect()->back()->with('success', 'Video Category deleted successfully.');
    }

    private function uniqueSlug($name, $ignoreId = null)
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (VideoCategory::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
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
