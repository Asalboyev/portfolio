<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Lang;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function uploadImageViaAjax(Request $request)
     {
         $name = [];
         $original_name = [];
         foreach ($request->file('file') as $key => $value) {
             $image = uniqid() . time() . '.' . $value->getClientOriginalExtension();
             $destinationPath = public_path().'/site/images/products/';
             $value->move($destinationPath, $image);
             $name[] = $image;
             $original_name[] = $value->getClientOriginalName();
         }

         return response()->json([
             'name'          => $name,
             'original_name' => $original_name
         ]);
     }

    public function index()
    {
        $languages = Lang::all();
        $products = Product::latest()->paginate(10);
//        $categories = ProductCategory::with('subPosts.category')->where('category_id', null)->orderBy('id')->get();
//        $categories = ProductCategory::with('subProduct.product_category')->where('product_category_id', null)->orderBy('id')->get();

        return view('admin.products.index',compact('products','languages',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
//        $categories = Category::with('subPosts.category')->where('category_id', null)->orderBy('id')->get();
        $categories = ProductCategory::query()->get();

//        $categories = Category::where('category_id', '!=', null)->get();
        return view('admin.products.create',compact('languages','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title.en' => 'required',
            'price'=> 'required',

        ]);

        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $image_names = [];
            foreach ($files as $file) {
                $image_name = time() . '_' . $file->getClientOriginalName();
               // Storage:
                $file->move(public_path('site/images/products'), $image_name);
                $image_names[] = $image_name;
            }
            $requestData['photo'] = $image_names;
        }
        if ($request->has('optional_key')) {
            foreach ($request->input('optional_key') as $language => $values) {
                $languageValues = [];
                foreach ($values as $value) {
                    $languageValues[] = $value;
                }
                $requestData['optional_key'][$language] = $languageValues;
            }
        }
        if ($request->has('standard_key')) {
            foreach ($request->input('standard_key') as $language => $values) {
                $languageValues = [];
                foreach ($values as $value) {
                    $languageValues[] = $value;
                }
                $requestData['standard_key'][$language] = $languageValues;
            }
        }

        $product = Product::create($requestData);
        return redirect()->route('admin.products.index')->with(['message' => 'Successfully added!']);
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
    public function edit(Product $product)
    {
        $categories = ProductCategory::query()->get();
        $languages = Lang::all();


        // return $photos;
        return view('admin.products.edit',compact( 'categories','product','languages'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title.en' => 'required',
            'price'=> 'required',
        ]);

        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $image_names = [];
            foreach ($files as $file) {
                $image_name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('site/images/products'), $image_name);
                $image_names[] = $image_name;
            }
            $requestData['photo'] = $image_names;
        }
        if ($request->has('optional_key')) {
            foreach ($request->input('optional_key') as $language => $values) {
                $languageValues = [];
                foreach ($values as $value) {
                    $languageValues[] = $value;
                }
                $requestData['optional_key'][$language] = $languageValues;
            }
        }

        if ($request->has('standard_key')) {
            foreach ($request->input('standard_key') as $language => $values) {
                $languageValues = [];
                foreach ($values as $value) {
                    $languageValues[] = $value;
                }
                $requestData['standard_key'][$language] = $languageValues;
            }
        }

        $product->update($requestData);

        return redirect()->route('admin.products.index')->with(['message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()->route('admin.products.index')->with(['message' => 'Successfully deleted!']);
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
        $categories = Product::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('status', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $result = collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.products.search', compact('result', 'search_word'));
    }
    public function status(Request $request) {
        $status = $request->input('status'); // select tanlov qiymati
        $query = Product::query();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $products = $query->paginate(10);

        return view('admin.products.status', compact('products', ));
    }
}
