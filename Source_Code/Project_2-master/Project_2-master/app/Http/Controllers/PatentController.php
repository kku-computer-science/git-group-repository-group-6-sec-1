<?php

namespace App\Http\Controllers;

use App\Models\Academicwork;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;

class PatentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Academicwork::class, 'patent');
    }

    public function index()
    {
        $id = auth()->user()->id;
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('staff')) {
            $patents = Academicwork::where('ac_type', '!=', 'book')->get();
        } else {
            $patents = Academicwork::with('user')
                ->where('ac_type', '!=', 'book')
                ->whereHas('user', function ($query) use ($id) {
                    $query->where('users.id', '=', $id);
                })->paginate(10);
        }
        return view('patents.index', compact('patents'));
    }

    public function create()
    {
        $users = User::role(['teacher', 'student'])->get();
        return view('patents.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ac_name' => 'required',
            'ac_type' => 'required',
            'ac_year' => 'required',
            'ac_refnumber' => 'required',
        ]);

        $input = $request->except(['_token']);
        $acw = Academicwork::create($input);

        $id = auth()->user()->id;
        $x = 1;
        $length = count($request->moreFields);
        foreach ($request->moreFields as $value) {
            if ($value['userid'] != null) {
                $authorType = ($x === 1) ? 1 : (($x === $length) ? 3 : 2);
                $acw->user()->attach($value, ['author_type' => $authorType]);
            }
            $x++;
        }

        if (isset($input['fname'][0]) && !empty($input['fname'][0])) {
            $x = 1;
            $length = count($request->input('fname'));
            foreach ($request->input('fname') as $key => $value) {
                $data = [
                    'fname' => $input['fname'][$key],
                    'lname' => $input['lname'][$key],
                ];
                $author = Author::firstOrCreate(
                    ['author_fname' => $data['fname'], 'author_lname' => $data['lname']],
                    ['author_fname' => $data['fname'], 'author_lname' => $data['lname']]
                );
                $authorType = ($x === 1) ? 1 : (($x === $length) ? 3 : 2);
                $acw->author()->syncWithoutDetaching([$author->id => ['author_type' => $authorType]]);
                $x++;
            }
        }

        return redirect()->route('patents.index')->with('success', 'Patent created successfully.');
    }

    public function show(Academicwork $patent)
    {
        $patent->load('user', 'author');
        return view('patents.show', compact('patent'));
    }

    public function edit(Academicwork $patent)
    {
        $users = User::role(['teacher', 'student'])->get();
        return view('patents.edit', compact('patent', 'users'));
    }

    public function update(Request $request, Academicwork $patent)
    {
        $this->validate($request, [
            'ac_name' => 'required',
            'ac_type' => 'required',
            'ac_year' => 'required',
            'ac_refnumber' => 'required',
        ]);

        $input = $request->except(['_token']);
        $patent->update([
            'ac_name' => $request->ac_name,
            'ac_type' => $request->ac_type,
            'ac_year' => $request->ac_year,
            'ac_refnumber' => $request->ac_refnumber,
        ]);

        $patent->user()->detach();
        $x = 1;
        $length = count($request->moreFields);
        foreach ($request->moreFields as $value) {
            if ($value['userid'] != null) {
                $authorType = ($x === 1) ? 1 : (($x === $length) ? 3 : 2);
                $patent->user()->attach($value, ['author_type' => $authorType]);
            }
            $x++;
        }

        $patent->author()->detach();
        if (isset($input['fname'][0]) && !empty($input['fname'][0])) {
            $x = 1;
            $length = count($request->input('fname'));
            foreach ($request->input('fname') as $key => $value) {
                $data = [
                    'fname' => $input['fname'][$key],
                    'lname' => $input['lname'][$key],
                ];
                $author = Author::firstOrCreate(
                    ['author_fname' => $data['fname'], 'author_lname' => $data['lname']],
                    ['author_fname' => $data['fname'], 'author_lname' => $data['lname']]
                );
                $authorType = ($x === 1) ? 1 : (($x === $length) ? 3 : 2);
                $patent->author()->syncWithoutDetaching([$author->id => ['author_type' => $authorType]]);
                $x++;
            }
        }

        return redirect()->route('patents.index')->with('success', 'Patent updated successfully');
    }

    public function destroy(Academicwork $patent)
    {
        $patent->delete();
        return redirect()->route('patents.index')->with('success', 'Patent deleted successfully');
    }
}