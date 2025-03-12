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
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $source = Source_data::all();
        $users = User::role(['teacher', 'student'])->get();
        return view('papers.create', compact('source', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'paper_name' => 'required|unique:papers,paper_name',
            'paper_type' => 'required',
            'paper_sourcetitle' => 'required',
            'paper_yearpub' => 'required',
            'paper_volume' => 'required',
            'paper_doi' => 'required',
        ]);

        $input = $request->except(['_token']);
        $key = $input['keyword'];
        $key = explode(', ', $key);
        $myNewArray = [];
        foreach ($key as $val) {
            $myNewArray[] = ['$' => $val]; // Simplified structure
        }
        $input['keyword'] = $myNewArray;

        $paper = Paper::create($input);

        foreach ($request->cat as $value) {
            $paper->source()->attach($value);
        }

        foreach ($request->moreFields as $key => $value) {
            if ($value['userid'] != null) {
                $paper->teacher()->attach($value, ['author_type' => $request->pos[$key]]);
            }
        }

        if (isset($input['fname'][0]) && !empty($input['fname'][0])) {
            foreach ($request->input('fname') as $key => $value) {
                $data = ['fname' => $input['fname'][$key], 'lname' => $input['lname'][$key]];
                $author = Author::where([['author_fname', '=', $data['fname']], ['author_lname', '=', $data['lname']]])->first();

                if (!$author) {
                    $author = new Author;
                    $author->author_fname = $data['fname'];
                    $author->author_lname = $data['lname'];
                    $author->save();
                }

                $paper->author()->attach($author->id, ['author_type' => $request->pos2[$key]]);
            }
        }

        return redirect()->route('papers.index')->with('success', 'Paper created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paper = Paper::findOrFail($id);
        $currentLanguage = App::getLocale();

        // Handle the keyword field
        if (is_array($paper->keyword)) {
            // Extract '$' values from nested arrays
            $keywordsArray = array_column($paper->keyword, '$');
            $originalKeywords = implode(', ', $keywordsArray);
        } elseif (is_string($paper->keyword)) {
            $originalKeywords = $paper->keyword;
        } else {
            $originalKeywords = '';
        }

        // Process and translate keywords
        if (!empty($originalKeywords)) {
            $keywords = explode(',', $originalKeywords);
            $translatedKeywords = [];
            foreach ($keywords as $keyword) {
                $translatedKeywords[] = app('TranslationService')->translate(trim($keyword), $currentLanguage);
            }
            $translatedKeywords = implode(', ', $translatedKeywords);
        } else {
            $translatedKeywords = 'No Keywords Available';
        }

        // Translate abstract
        $translatedAbstract = ($currentLanguage !== 'en')
            ? app('TranslationService')->translate($paper->abstract, $currentLanguage)
            : $paper->abstract;

        return view('papers.show', compact('paper', 'translatedAbstract', 'translatedKeywords'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $paper = Paper::findOrFail($id);

            $k = collect($paper['keyword']);
            $val = $k->implode('$', ', ');
            $paper['keyword'] = $val;

            $this->authorize('update', $paper);

            $sources = Source_data::pluck('source_name', 'source_name')->all();
            $paperSource = $paper->source->pluck('source_name', 'source_name')->all();
            $users = User::role(['teacher', 'student'])->get();

            return view('papers.edit', compact('paper', 'users', 'paperSource', 'sources'));
        } catch (DecryptException $e) {
            return abort(404, "Page not found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paper $paper)
    {
        $this->validate($request, [
            'paper_type' => 'required',
            'paper_sourcetitle' => 'required',
            'paper_volume' => 'required',
            'paper_issue' => 'required',
            'paper_citation' => 'required',
            'paper_page' => 'required',
        ]);

        $input = $request->except(['_token']);
        $key = $input['keyword'];
        $key = explode(', ', $key);
        $myNewArray = [];
        foreach ($key as $val) {
            $myNewArray[] = ['$' => $val];
        }
        $input['keyword'] = $myNewArray;

        $paper->update($input);

        $paper->author()->detach();
        $paper->teacher()->detach();
        $paper->source()->detach();

        foreach ($request->sources as $value) {
            $v = Source_data::select('id')->where('source_name', '=', $value)->get();
            $paper->source()->attach($v);
        }

        foreach ($request->moreFields as $key => $value) {
            if ($value['userid'] != null) {
                $paper->teacher()->attach($value, ['author_type' => $request->pos[$key]]);
            }
        }

        if (isset($input['fname'][0]) && !empty($input['fname'][0])) {
            foreach ($request->input('fname') as $key => $value) {
                $data = ['fname' => $input['fname'][$key], 'lname' => $input['lname'][$key]];
                $author = Author::where([['author_fname', '=', $data['fname']], ['author_lname', '=', $data['lname']]])->first();

                if (!$author) {
                    $author = new Author;
                    $author->author_fname = $data['fname'];
                    $author->author_lname = $data['lname'];
                    $author->save();
                }

                $paper->author()->attach($author->id, ['author_type' => $request->pos2[$key]]);
            }
        }

        return redirect()->route('papers.index')->with('success', 'Paper updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $paper = Paper::findOrFail($id);
            $paper->delete();

            // ✅ ส่ง response กลับเป็น JSON หลังลบสำเร็จ
            return response()->json(['success' => 'Paper deleted successfully']);
        } catch (\Exception $e) {
            // ส่งข้อความ error ถ้าเกิดข้อผิดพลาด
            return response()->json(['error' => 'Delete Failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Export papers to Excel.
     */
    public function export(Request $request)
    {
        return Excel::download(new ExportUser, 'papers.xlsx');
    }
}
