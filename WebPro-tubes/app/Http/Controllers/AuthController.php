<?php
////test
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the login credentials
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation
            $request->session()->regenerate();

            // Redirect based on user role
            $user = Auth::user();
            $redirectRoute = $user->role === 'admin' ? route('home.admin') : route('home.customer');

            // Check if the request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'redirect' => $redirectRoute,
                ]);
            }

            return redirect()->intended($redirectRoute);
        }

        // If authentication fails
        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password.',
            ], 401);
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
        ]);

        // Coba simpan data
        try {
            User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password), // Enkripsi password
                'role' => 'customer',
            ]);

            return redirect()->route('login')->with('message', 'Registration successful. Please login.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to register. Please try again.');
        }
    }

    public function showResetRequest()
    {
        return view('auth.password.reset-password-request');
    }

    public function sendResetLink(Request $request)
    {
        return back()->with('message', 'Password reset link :');
    }

    public function showResetForm($token)
    {
        $username = request('username'); // Ambil username dari query parameter
        return view('auth.password.reset-password', compact('token', 'username'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required|confirmed|min:6',
        ]);
    
        $user = User::where('username', $request->username)->first();
    
        if (!$user) {
            return response()->json(['errors' => ['username' => 'Invalid username']], 422);
        }
    
        if (Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => ['password_same' => 'Password baru sama dengan password sebelumnya']], 422);
        }
    
        $user->update([
            'password' => bcrypt($request->password),
        ]);
    
        return response()->json(['message' => 'Password successfully updated. Please login.']);
    }
    


    public function generateResetLink(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
        ]);

        // Generate link reset
        $resetLink = route('password.reset', [
            'username' => $request->username,
            'token' => Str::random(32), // Gunakan Str::random()
        ]);

        return redirect()->back()->with('reset_link', $resetLink);
    }

}
