<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
   

    public function showAdmin()
    {
        $users = User::all(); 
        return view('profile.admin-show', compact('users')); 
    }
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
        ]);

    
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();
        
        return redirect()->route('admin.users.show')->with('success', 'Profile updated successfully');
    }
    public function updateAjax(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
        ]);

        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('profile.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'new_password' => 'nullable',
        ]);

        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('admin.users.show')
            ->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.show')
                ->with('error', 'Cannot delete admin users');
        }

        $user->delete();

        return redirect()->route('admin.users.show')
            ->with('success', 'User deleted successfully');
    }
}