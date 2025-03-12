<?php

namespace App\Http\Controllers;

use App\Models\Expertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpertiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = auth()->user()->id;
        if (auth()->user()->hasRole('admin')) {
            $experts = Expertise::orderBy('id', 'asc')->get(); // Order by ID in ascending order
        } else {
            $experts = Expertise::with('user')
                ->whereHas('user', function ($query) use ($id) {
                    $query->where('users.id', '=', $id);
                })
                ->orderBy('id', 'asc') // Order by ID in ascending order
                ->paginate(10); // Pagination
        }
    
        return view('expertise.index', compact('experts'));
    }
    
    

    public function create()
    {
        return view('expertise.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expert_name.*' => 'required|string|max:100',
            'expert_name_th.*' => 'nullable|string|max:255',
            'expert_name_zh.*' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id' // Now required for all submissions
        ]);

        try {
            $userId = $request->user_id; // Always use the selected user_id

            foreach ($request->expert_name as $index => $name) {
                $expertiseData = [
                    'expert_name' => $name,
                    'expert_name_th' => $request->expert_name_th[$index] ?? null,
                    'expert_name_zh' => $request->expert_name_zh[$index] ?? null,
                    'user_id' => $userId,
                ];

                Expertise::create($expertiseData);
            }

            return redirect()->route('experts.index')
                            ->with('success', 'experts.created_success');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'experts.error_occurred')
                            ->withInput();
        }
    }

    public function edit($id)
    {
        $expertise = Expertise::findOrFail($id);
        
        if (!Auth::user()->hasRole('admin') && $expertise->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json($expertise);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'expert_name' => 'required|string|max:100',
            'expert_name_th' => 'nullable|string|max:255',
            'expert_name_zh' => 'nullable|string|max:255',
        ]);

        $expertise = Expertise::findOrFail($id);
        
        if (!Auth::user()->hasRole('admin') && $expertise->user_id !== Auth::id()) {
            return redirect()->route('experts.index')->with('error', 'experts.unauthorized');
        }

        $expertise->update([
            'expert_name' => $request->expert_name,
            'expert_name_th' => $request->expert_name_th,
            'expert_name_zh' => $request->expert_name_zh,
        ]);

        return redirect()->route('experts.index')->with('success', 'experts.updated_success');
    }

    public function destroy($id)
    {
        $expertise = Expertise::findOrFail($id);
        
        if (!Auth::user()->hasRole('admin') && $expertise->user_id !== Auth::id()) {
            return redirect()->route('experts.index')
                            ->with('error', 'experts.unauthorized');
        }

        $expertise->delete();
        return redirect()->route('experts.index')
                        ->with('success', 'experts.deleted_success');
    }
}
