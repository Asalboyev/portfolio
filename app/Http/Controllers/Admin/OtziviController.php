<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Otzivi;
use App\Models\Lang;
use App\Models\Zayavka;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OtziviController extends Controller{


    public function ajax(Request $request)
    {
        $name = [];
        $original_name = [];
        foreach ($request->file('file') as $key => $value) {
            $image = uniqid() . time() . '.' . $value->getClientOriginalExtension();
            $destinationPath = public_path().'/site/images/info/';
            $value->move($destinationPath, $image);
            $name[] = $image;
            $original_name[] = $value->getClientOriginalName();
        }

        return response()->json([
            'name'          => $name,
            'original_name' => $original_name
        ]);
    }

    public function in_store(Request $request, string $id)
    {
        // 1. Validatsiya
        $request->validate([
            'phone' => 'required',
        ]);

        // 2. Request ma'lumotlarini olish
        $informa = Information::findOrFail($id);

        $requestData = $request->all();

        // 3. Fayllarni yuklash
        if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $image_names = [];

            foreach ($files as $file) {
                $image_name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('site/images/info'), $image_name);
                $image_names[] = $image_name;
            }

            // Fayllarni JSON formatda saqlash
            $requestData['photo'] = json_encode($image_names);
        }

        // 4. Ma'lumotlarni yangilash
        $informa->update($requestData);

        // 5. Foydalanuvchini boshqa sahifaga yo'naltirish
        return redirect()->route('admin.information.upload')->with(['success' => 'Successfully save!']);
    }


    public function index(){
        $languages = Lang::all();
        $otzivis = Otzivi::query()->paginate(10);
        return view('admin.otzivi.index',compact('languages','otzivis',));
    }

    public function z_index(){
        $languages = Lang::all();
        $zayavkas = Zayavka::query()->paginate(10);
        return view('admin.otzivi.zayavka',compact('languages','zayavkas',));
    }
    public function in_index(Information $information = null){
        $languages = Lang::all();
          if (!$information) {
        $information = Information::find(1);
    }
        return view('admin.otzivi.information',compact('languages','information',));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
//        $categories = Category::with('subPosts.category')->where('category_id', null)->orderBy('id')->get();

//        $categories = Category::where('category_id', '!=', null)->get();
        return view('admin.otzivi.create',compact('languages',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'FIO.uz' => 'required',
            'job_title.uz' => 'required',
        ]);

        $data = $request->all();

        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('upload/team-images', 'public');
            $data['photo'] = $path;
        }
        Otzivi::create($data);
        return redirect()->route('admin.otzivi.index')->with(['message' => 'Successfully added!']);

    }


    public function edit(Otzivi $otzivi)
    {
        $languages = Lang::all();
        return view('admin.otzivi.edit',compact('otzivi','languages'));

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

        $otzivi = Otzivi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Eski rasmni o'chirish
            if ($otzivi->photo) {
                Storage::disk('public')->delete($otzivi->photo);
            }

            // Yangi rasmni saqlash
            $path = $request->file('photo')->store('upload/otzivi-images', 'public');
            $data['photo'] = $path;
        }

        $otzivi->update($data);
        return redirect()->route('admin.otzivi.index')->with(['message' => 'Successfully updated!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $otzivi = Otzivi::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($otzivi->photo) {
            Storage::disk('public')->delete($otzivi->photo);
        }

        $otzivi->delete();

        return redirect()->route('admin.otzivi.index')->with(['message' => 'Successfully deleted!']);
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->file('upload')->getClientOriginalName();
            $request->file('upload')->move(public_path('site/images/team/'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('site/images/team/' . $fileName); // URL uchun asset funksiyasidan foydalanamiz
            $msg = 'Image successfully uploaded';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }


    public function deactivate($id)
    {
        $zayavka = Zayavka::findOrFail($id);
        if ($zayavka->status === 'active') {
            $zayavka->status = 'inactive';
        } elseif ($zayavka->status === 'inactive') {
            $zayavka->status = 'active';
        }
        $zayavka->save();
        return back();
    }
    public function z_destroy($id)
    {
        $otzivi = Zayavka::findOrFail($id);



        $otzivi->delete();

        return redirect()->route('admin.z.index')->with(['message' => 'Successfully deleted!']);
    }

    public function search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $otzivis = Otzivi::where('FIO', 'like', '%' . $search_term . '%')
            ->orWhere('job_title', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $otzivis = collect()
            ->merge($otzivis);

        $search_word = $request->search;

        return view('admin.otzivi.search', compact('otzivis', 'search_word'));
    }
    public function z_search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $zayavkas = Zayavka::where('first_name', 'like', '%' . $search_term . '%')
            ->orWhere('last_name', 'like', '%' . $search_term . '%')
            ->orWhere('phone_number', 'like', '%' . $search_term . '%')
            ->orWhere('descriptions', 'like', '%' . $search_term . '%')
            ->orWhere('status', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $zayavkas = collect()
            ->merge($zayavkas);

        $search_word = $request->search;

        return view('admin.otzivi.z_search', compact('zayavkas', 'search_word'));
    }
    public function status(Request $request) {
        $status = $request->input('status'); // select tanlov qiymati
        $query = Zayavka::query();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $zayavkas = $query->paginate(10);

        return view('admin.otzivi.status', compact('zayavkas', ));
    }

}
