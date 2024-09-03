<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller {


    public function index(){
    $languages = Lang::all();
    $faqs = Faq::query()->paginate(10);
    return view('admin.faq.index',compact('languages','faqs',));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $languages = Lang::all();
    return view('admin.faq.create',compact('languages',));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'question.uz' => 'required',
        'answer.uz' => 'required',
    ]);

    $data = $request->all();

    if($request->hasFile('photo')) {
        $path = $request->file('photo')->store('upload/faq-images', 'public');
        $data['photo'] = $path;
    }
    Faq::create($data);
    return redirect()->route('admin.faq.index')->with(['message' => 'Successfully added!']);

}


    public function edit(Faq $faq)
{
    $languages = Lang::all();
    return view('admin.faq.edit',compact('faq','languages'));

}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{

    $request->validate([
        'FIO.uz' => 'required',
        'job_title.uz' => 'required',
    ]);

    $faq = Faq::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('photo')) {
        // Eski rasmni o'chirish
        if ($faq->photo) {
            Storage::disk('public')->delete($faq->photo);
        }

        $path = $request->file('photo')->store('upload/faq-images', 'public');
        $data['photo'] = $path;
    }

    $faq->update($data);
    return back()->with(['message' => 'Successfully updated!']);

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $team = Faq::findOrFail($id);

    // Rasmlar mavjud bo'lsa, ularni o'chirish
    if ($team->photo) {
        Storage::disk('public')->delete($team->photo);
    }

    $team->delete();

    return redirect()->route('admin.faq.index')->with(['message' => 'Successfully deleted!']);
}
    public function upload(Request $request)
{
    if ($request->hasFile('upload')) {
        $fileName = $request->file('upload')->getClientOriginalName();
        $request->file('upload')->move(public_path('site/images/faq/'), $fileName);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = asset('site/images/faq/' . $fileName); // URL uchun asset funksiyasidan foydalanamiz
        $msg = 'Image successfully uploaded';

        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        @header('Content-type: text/html; charset=utf-8');
        echo $response;
    }
}
public function search(Request $request) {
    $search_term = mb_strtolower($request->search);

    // Search in Category models
    $faqs = Faq::where('question', 'like', '%' . $search_term . '%')
        ->orWhere('answer', 'like', '%' . $search_term . '%')
        ->orWhere('order', 'like', '%' . $search_term . '%')->get();

    // Merge all results
    $faqs = collect()
        ->merge($faqs);

    $search_word = $request->search;

    return view('admin.faq.search', compact('faqs', 'search_word'));
}
}


