<?php

namespace App\Http\Controllers;

use App\Models\Academicwork;
use Illuminate\Http\Request;

class AcademicworkController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Academicwork::class, 'academicwork');
    }

    public function index()
    {
        $academicworks = Academicwork::with(['user', 'author'])->get();
        return response()->json($academicworks);
    }

    public function view(Academicwork $academicwork)
    {
        $academicwork->load('user', 'author');
        return response()->json($academicwork);
    }

    public function edit(Academicwork $academicwork)
    {
        $academicwork->load('user', 'author');
        return response()->json($academicwork);
    }

    public function update(Request $request, Academicwork $academicwork)
    {
        $validated = $request->validate([
            'ac_name' => 'required|string|max:255',
            'ac_type' => 'required|string',
            'ac_sourcetitle' => 'required|string',
            'ac_year' => 'required|integer',
            'ac_refnumber' => 'required|string',
            'ac_page' => 'required|integer',
        ]);

        $academicwork->update($validated);
        return response()->json(['message' => 'Academic work updated successfully']);
    }

    public function destroy(Academicwork $academicwork)
    {
        $academicwork->delete();
        return response()->json(['message' => 'Academic work deleted successfully']);
    }
}