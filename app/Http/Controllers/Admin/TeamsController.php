<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lang;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Lang::all();
        $teams = Team::query()->paginate(10);
        $categories = Category::with('subPosts.category')->where('category_id', null)->orderBy('id')->get();

        return view('admin.teams.index',compact('languages','teams','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
//        $categories = Category::with('subPosts.category')->where('category_id', null)->orderBy('id')->get();
        $categories = Category::query()->get();

//        $categories = Category::where('category_id', '!=', null)->get();
        return view('admin.teams.create',compact('languages','categories'));
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
        Team::create($data);
        return redirect()->route('admin.teams.index')->with(['message' => 'Successfully added!']);

    }


    public function edit(Team $team)
    {
        $categories = Category::query()->get();
        $languages = Lang::all();
        return view('admin.teams.edit',compact('categories','team','languages'));

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

        $team = Team::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Eski rasmni o'chirish
            if ($team->photo) {
                Storage::disk('public')->delete($team->photo);
            }

            // Yangi rasmni saqlash
            $path = $request->file('photo')->store('upload/team-images', 'public');
            $data['photo'] = $path;
        }

        $team->update($data);
        return redirect()->route('admin.teams.index')->with(['message' => 'Successfully updated!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($team->photo) {
            Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return redirect()->route('admin.teams.index')->with(['message' => 'Successfully deleted!']);
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
    public function search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $teams = Team::where('FIO', 'like', '%' . $search_term . '%')
            ->orWhere('job_title', 'like', '%' . $search_term . '%')
            ->orWhere('instagram', 'like', '%' . $search_term . '%')
            ->orWhere('tel_number', 'like', '%' . $search_term . '%')
            ->orWhere('telegram_nickname', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $teams = collect()
            ->merge($teams);

        $search_word = $request->search;

        return view('admin.teams.search', compact('teams', 'search_word'));
    }
}
