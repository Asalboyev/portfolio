<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $languages = Lang::all();

        $categories = PortfolioCategory::query()->paginate(10);

        return view('admin.portfolio_categories.index', compact('categories','languages'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
        $categories = PortfolioCategory::query()->get();

        // $categories = Category::with('categories')->orderBy('id')->get();
        return view('admin.portfolio_categories.create',compact('languages','categories'));
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

        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('upload/images', 'public');
            $data['photo'] = $path;
        }

        PortfolioCategory::create($data);

        return redirect()->route('admin.portfolio_categories.index')->with(['success' => 'Successfully added!']);
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
    public function edit(PortfolioCategory $portfolio_category)
    {
        $languages = Lang::all();
        $categories = PortfolioCategory::query()->get();
        return view('admin.portfolio_categories.edit',compact('languages','categories','portfolio_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title.en' => 'required'
        ]);

        $category = PortfolioCategory::findOrFail($id);
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

        return redirect()->route('admin.portfolio_categories.index')->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = PortfolioCategory::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($category->photo) {
            Storage::disk('public')->delete($category->photo);
        }

        $category->delete();

        return redirect()->route('admin.portfolio_categories.index')->with(['message' => 'Successfully deleted!']);
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
        $categories = PortfolioCategory::where('title', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $result = collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.portfolio_categories.search', compact('result', 'search_word'));
    }

}
