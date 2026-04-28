<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:patient,medecin',
        ]);

        if ($request->role === 'medecin' && $request->email !== env('MEDECIN_EMAIL')) {
            return back()->withErrors([
                'email' => 'Cet email n\'est pas autorisé comme médecin !'
            ])->withInput();
        }

        $user = User::create([
            'nom'     => $request->nom,  // ✅ corrigé
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);

        if ($user->role === 'medecin') {
            return redirect('/medecin/dashboard');
        }
        return redirect('/patient/accueil');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'medecin') {
                return redirect('/medecin/dashboard');
            }
            return redirect('/patient/accueil');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}