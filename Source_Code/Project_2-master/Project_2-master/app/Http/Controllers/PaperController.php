<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Exports\ExportPaper;
use App\Exports\ExportUser;
use App\Exports\UsersExport;
use App\Models\Author;
use App\Models\Paper;
use App\Models\Source_data;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = auth()->user()->id;

        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('staff')) {
            $papers = Paper::with('teacher', 'author')->orderBy('paper_yearpub', 'desc')->get();
        } else {
            $papers = Paper::with('teacher', 'author')
                ->whereHas('teacher', function ($query) use ($id) {
                    $query->where('users.id', '=', $id);
                })
                ->orderBy('paper_yearpub', 'desc')
                ->get();
        }

        return view('papers.index', compact('papers'));
    }

    public function create()
    {
        $this->authorize('create', Paper::class);
        $source = Source_data::all();
        $users = User::role(['teacher', 'student'])->get();
        return view('papers.create', compact('source', 'users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Paper::class);

        $this->validate($request, [
            'paper_name' => 'required|unique:papers,paper_name',
            'paper_type' => 'required',
            'paper_sourcetitle' => 'required',
            'paper_yearpub' => 'required',
            'paper_volume' => 'required',
            'paper_doi' => 'required',
        ]);

        $input = $request->only(['paper_name', 'paper_type', 'paper_sourcetitle', 'paper_url', 'paper_yearpub', 'paper_volume', 'paper_issue', 'paper_citation', 'paper_page', 'paper_doi']);
        $paper = Paper::create($input);

        foreach ($request->cat as $value) {
            $paper->sources()->attach($value);
        }

        foreach ($request->moreFields as $key => $value) {
            if ($value['userid'] != null) {
                $paper->teacher()->attach($value);
            }
        }

        if (isset($request->fname[0]) && !empty($request->fname[0])) {
            foreach ($request->input('fname') as $key => $value) {
                $data = ['fname' => $request->fname[$key], 'lname' => $request->lname[$key]];
                $author = Author::where([['author_fname', '=', $data['fname']], ['author_lname', '=', $data['lname']]])->first();

                if (!$author) {
                    $author = new Author;
                    $author->author_fname = $data['fname'];
                    $author->author_lname = $data['lname'];
                    $author->save();
                }

                $paper->author()->attach($author->id);
            }
        }

        return redirect()->route('papers.index')->with('success', 'Paper created successfully.');
    }

    public function show($id)
    {
        $paper = Paper::findOrFail($id);
        $this->authorize('view', $paper);
    
        $currentLanguage = App::getLocale();
    
        // ดึง Abstract ที่แปล
        $translatedAbstract = ($currentLanguage !== 'en' && isset($paper->abstract))
            ? app('TranslationService')->translate($paper->abstract, $currentLanguage)
            : ($paper->abstract ?? 'No Abstract Available');
    
        // ดึง Keywords และแปลง JSON ให้ถูกต้อง
        $translatedKeywords = collect(json_decode($paper->keywords))->pluck('$')->implode(', ') ?: 'No Keywords Available';
    
        return view('papers.show', compact('paper', 'translatedAbstract', 'translatedKeywords'));
    }
    

    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $paper = Paper::findOrFail($id);

            $this->authorize('update', $paper);

            $sources = Source_data::pluck('source_name', 'source_name')->all();
            $paperSource = $paper->sources()->pluck('source_name', 'source_name')->all();
            $users = User::role(['teacher', 'student'])->get();

            return view('papers.edit', compact('paper', 'users', 'paperSource', 'sources'));
        } catch (DecryptException $e) {
            return abort(404, "Page not found");
        }
    }

    public function update(Request $request, Paper $paper)
    {
        $this->authorize('update', $paper);

        $this->validate($request, [
            'paper_type' => 'required',
            'paper_sourcetitle' => 'required',
            'paper_volume' => 'required',
            'paper_issue' => 'required',
            'paper_citation' => 'required',
            'paper_page' => 'required',
        ]);

        $input = $request->only(['paper_name', 'paper_type', 'paper_sourcetitle', 'paper_url', 'paper_yearpub', 'paper_volume', 'paper_issue', 'paper_citation', 'paper_page', 'paper_doi']);
        $paper->update($input);

        $paper->author()->detach();
        $paper->teacher()->detach();
        $paper->sources()->detach();

        foreach ($request->sources as $value) {
            $v = Source_data::select('id')->where('source_name', '=', $value)->get();
            $paper->sources()->attach($v);
        }

        foreach ($request->moreFields as $key => $value) {
            if ($value['userid'] != null) {
                $paper->teacher()->attach($value);
            }
        }

        if (isset($request->fname[0]) && !empty($request->fname[0])) {
            foreach ($request->input('fname') as $key => $value) {
                $data = ['fname' => $request->fname[$key], 'lname' => $request->lname[$key]];
                $author = Author::where([['author_fname', '=', $data['fname']], ['author_lname', '=', $data['lname']]])->first();

                if (!$author) {
                    $author = new Author;
                    $author->author_fname = $data['fname'];
                    $author->author_lname = $data['lname'];
                    $author->save();
                }

                $paper->author()->attach($author->id);
            }
        }

        return redirect()->route('papers.index')->with('success', 'Paper updated successfully');
    }

    public function destroy(Paper $paper)
    {
        $this->authorize('delete', $paper);

        $paper->teacher()->detach();
        $paper->author()->detach();
        $paper->sources()->detach();
        $paper->delete();

        return redirect()->route('papers.index')->with('success', 'Paper deleted successfully');
    }

    public function export(Request $request)
    {
        return Excel::download(new ExportUser, 'papers.xlsx');
    }

}