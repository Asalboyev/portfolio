<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\PortfolioCategory;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use




class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = Category::with('categories')  // Boshqa kategoriyalar bilan bog'liq bo'lgan relatssiyalarni kiritish
        // ->whereNull('category_id')  // category_id maydoni null bo'lganlar
        // ->orderBy('id')            // id bo'yicha tartiblash
        // ->get();
        $categories = Category::with('categories')->whereNull('category_id')->orderBy('id')->get();

         $languages = Lang::all();
        // $categories = Category::with('categories')->whereNull('category_id')->orderBy('id')->get();

        $subcat = Category::all();

        return view('admin.categories.index', compact('categories','languages','subcat'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();

        // $categories = Category::with('categories')->orderBy('id')->get();
        return view('admin.categories.create',compact('languages'));
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
            $path = $request->file('photo')->store('upload/images', 'public');
            $data['photo'] = $path;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with(['message' => 'Successfully added!']);
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
    public function edit(Category $category)
    {
        $languages = Lang::all();
        return view('admin.categories.edit',compact('languages','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title.uz' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Eski rasmni o'chirish
            if ($category->photo) {
                Storage::disk('public')->delete($category->photo);
            }

            // Yangi rasmni saqlash
            $path = $request->file('photo')->store('upload/images', 'public');
            $data['photo'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with(['message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $category = Category::findOrFail($id);

    // Rasmlar mavjud bo'lsa, ularni o'chirish
    if ($category->photo) {
        Storage::disk('public')->delete($category->photo);
    }

    $category->delete();

    return redirect()->route('admin.categories.index')->with(['message' => 'Successfully deleted!']);
}
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->file('upload')->getClientOriginalName();
            $request->file('upload')->move(public_path('site/images/category/'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('site/images/category/' . $fileName); // URL uchun asset funksiyasidan foydalanamiz
            $msg = 'Image successfully uploaded';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $categories = Category::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('status', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $result = collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.categories.search', compact('result', 'search_word'));
    }


}
