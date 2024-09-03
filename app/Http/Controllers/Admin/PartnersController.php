<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Servic;
use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Lang::all();
        $partnerts = Partner::query()->paginate(10);

        return view('admin.partners.index',compact('languages','partnerts'));
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
            Storage::disk('public')->put('upload/partners-images/' . $imageName, $resizedImage);

            return response()->json(['success' => 'upload/partners-images/' . $imageName]);
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
        return view('admin.partners.create',compact('languages',));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title.en' => 'required'
        ]);
        $data = $request->all();
        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }

        Partner::create($data);
        return redirect()->route('admin.partners.index')->with(['message' => 'Successfully added!']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        $languages = Lang::all();
        return view('admin.partners.edit',compact('partner','languages'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id )
    {
        $request->validate([
            'title.en' => 'required'
        ]);

        $partner = Partner::findOrFail($id);
        $data = $request->all();

        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }

        $partner->update($data);
        return redirect()->route('admin.partners.index')->with(['message' => 'Successfully updated!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($partner->photo) {
            Storage::disk('public')->delete($partner->photo);
        }

        $partner->delete();

        return redirect()->route('admin.services.index')->with(['message' => 'Successfully deleted!']);
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->file('upload')->getClientOriginalName();
            $request->file('upload')->move(public_path('site/images/product/'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('site/images/product/' . $fileName); // URL uchun asset funksiyasidan foydalanamiz
            $msg = 'Image successfully uploaded';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $partnerts = Partner::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('link', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $partnerts = collect()
            ->merge($partnerts);

        $search_word = $request->search;

        return view('admin.partners.search', compact('partnerts', 'search_word'));
    }
}
