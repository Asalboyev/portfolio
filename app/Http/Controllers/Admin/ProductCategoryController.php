<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
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
        $categories = ProductCategory::with('product_category')->whereNull('product_category_id')->orderBy('id')->get();

        $languages = Lang::all();
        // $categories = Category::with('categories')->whereNull('category_id')->orderBy('id')->get();

        $subcat = ProductCategory::all();

        return view('admin.product_categories.index', compact('categories','languages','subcat'));

    }

    public function ajax(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('upload/product_categories-images', $imageName, 'public');

            return response()->json(['success' => $path]);
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
        $categories = ProductCategory::with('product_categories')->whereNull('product_category_id')->orderBy('id')->get();

        // $categories = Category::with('categories')->orderBy('id')->get();
        return view('admin.product_categories.create',compact('languages','categories'));
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

        ProductCategory::create($data);

        return redirect()->route('admin.product_categories.index')->with(['success' => 'Successfully added!']);
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
    public function edit(ProductCategory $product_category)
    {
        $languages = Lang::all();
        $categories = ProductCategory::with('product_categories')->whereNull('product_category_id')->orderBy('id')->get();
        return view('admin.product_categories.edit',compact('languages','categories','product_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title.en' => 'required'
        ]);

        $category = ProductCategory::findOrFail($id);
        $data = $request->all();

        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }
        $category->update($data);

        return redirect()->route('admin.product_categories.index')->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($category->photo) {
            Storage::disk('public')->delete($category->photo);
        }

        $category->delete();

        return redirect()->route('admin.product_categories.index')->with(['message' => 'Successfully deleted!']);
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
        $categories = ProductCategory::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('status', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $result = collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.product_categories.search', compact('result', 'search_word'));
    }

}
