<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\Lang;
use App\Models\Post;
use App\Models\Sertificate;
use App\Models\Servic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Lang::all();
        $services = Servic::query()->paginate(10);
        $categories = ServiceCategory::with('subService.service_category')->where('service_category_id', null)->orderBy('id')->get();

        return view('admin.services.index',compact('languages','services','categories'));
    }
    public function sertificates_index()
    {
        $languages = Lang::all();
        $sertificates = Sertificate::query()->paginate(10);
        return view('admin.services.sertificates',compact('languages','sertificates'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
//        $categories = Category::with('subPosts.category')->where('category_id', null)->orderBy('id')->get();
        $categories = ServiceCategory::query()->get();

//        $categories = Category::where('category_id', '!=', null)->get();
        return view('admin.services.create',compact('languages','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title.uz' => 'required'
        ]);

        $data = $request->all();

        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('upload/servic-images', 'public');
            $data['photo'] = $path;
        }
        Servic::create($data);
        return redirect()->route('admin.services.index')->with(['message' => 'Successfully added!']);

    }
    public function sertificates_store(Request $request)
    {
        $request->validate([
            'title.uz' => 'required'
        ]);

        $data = $request->all();

        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('upload/sertificate-images', 'public');
            $data['photo'] = $path;
        }
        Sertificate::create($data);
        return redirect()->route('admin.sertificates.index')->with(['message' => 'Successfully added!']);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servic $service)
    {
        $categories = ServiceCategory::query()->get();
        $languages = Lang::all();
        return view('admin.services.edit',compact('categories','service','languages'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id )
    {
        $request->validate([
            'title.uz' => 'required'
        ]);

        $servic = Servic::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Eski rasmni o'chirish
            if ($servic->photo) {
                Storage::disk('public')->delete($servic->photo);
            }

            // Yangi rasmni saqlash
            $path = $request->file('photo')->store('upload/servic-images', 'public');
            $data['photo'] = $path;
        }

        $servic->update($data);
        return redirect()->route('admin.services.index')->with(['message' => 'Successfully updated!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $servic = Servic::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($servic->photo) {
            Storage::disk('public')->delete($servic->photo);
        }

        $servic->delete();

        return redirect()->route('admin.services.index')->with(['message' => 'Successfully deleted!']);
    }
    public function sertificates_destroy($id)
    {
        Sertificate::find($id)->delete();

        // return back()->with(['message' => 'Successfully deleted!']);
        return redirect()->route('admin.sertificates.index')->with(['message' => 'Successfully deleted!']);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->file('upload')->getClientOriginalName();
            $request->file('upload')->move(public_path('site/images/services/'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('site/images/services/' . $fileName); // URL uchun asset funksiyasidan foydalanamiz
            $msg = 'Image successfully uploaded';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $categories = Servic::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('status', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $services= collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.services.search', compact('services', 'search_word'));
    }
    public function status(Request $request) {
        $status = $request->input('status'); // select tanlov qiymati
        $query = Servic::query();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $services = $query->paginate(10);

        return view('admin.services.status', compact('services', ));
    }
}
