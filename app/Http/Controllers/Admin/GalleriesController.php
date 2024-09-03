<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Gallery;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Lang::all();
        $galleries = Gallery::query()->paginate(10);

        return view('admin.galleries.index',compact('languages','galleries'));
    }

    public function ajax(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Resize the image
            $resizedImage = Image::make($image)->resize(2600, 2500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($image->getClientOriginalExtension());

            // Save the resized image
            Storage::disk('public')->put('upload/images/' . $imageName, $resizedImage);

            return response()->json(['success' => 'upload/images/' . $imageName]);
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$data = $request->all();
        //
        //if ($request->hasFile('photo')) {
        //    $path = $request->file('photo')->store('upload/post-images', 'public');
        //    $data['photo'] = $path;
        //}
        //
        //if ($request->hasFile('video')) {
        //    $videoPath = $request->file('video')->store('upload/post-videos', 'public');
        //    $data['video'] = $videoPath;
        //}
        //
        //Post::create($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);
        $data = $request->all();
        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }
        Gallery::create($data);
        return redirect()->route('admin.banners.index')->with(['message' => 'Successfully updated!']);
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */

     public function edit(Gallery $banner)
     {
         $languages = Lang::all();
         return view('admin.galleries.edit',compact('banner','languages'));

     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id )
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $partner = Gallery::findOrFail($id);
        $data = $request->all();

        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }

        $partner->update($data);
        return redirect()->route('admin.banners.index')->with(['message' => 'Successfully updated!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($gallery->photo) {
            Storage::disk('public')->delete($gallery->photo);
        }

        // Videolar mavjud bo'lsa, ularni o'chirish
        if ($gallery->video) {
            Storage::disk('public')->delete($gallery->video);
        }

        $gallery->delete();

        return redirect()->route('admin.banners.index')->with(['message' => 'Successfully deleted!']);
    }
}
