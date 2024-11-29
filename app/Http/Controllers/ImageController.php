<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get();
        return view('images.index', compact('images'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newImageName = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('uploads', $newImageName, 'public');
            
            Image::create([
                'filename' => $newImageName,
                'original_name' => $image->getClientOriginalName()
            ]);
        }

        return redirect()->back()->with('success', 'Image uploaded successfully');
    }
    

    public function destroy(Image $image)
    {
        Storage::delete('public/uploads/' . $image->filename);
        $image->delete();
        
        return redirect()->back()->with('success', 'Image deleted successfully');
    }

}