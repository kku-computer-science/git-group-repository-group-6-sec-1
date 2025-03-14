<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function updateUserPassword(Request $request, $id)
    {
        $request->validate([
            'newpassword' => 'required|min:6|confirmed', // Ensure password confirmation field exists
        ]);

        $user = User::findOrFail($id); // Fetch user by ID
        $user->update([
            'password' => Hash::make($request->newpassword),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
