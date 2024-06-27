<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        // if (Auth::check()) {
        //     dd("User is login.");
        // } else {
        //     dd("User is not login.");
        // }

        return view('auth.login');
        // return redirect('http://127.0.0.1:8000');
    }

    public function login_proses(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'passwd' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->passwd,
        ];

        // dd($data);
        if (Auth::attempt($data)) {

            $user = Auth::user()->name;

            
        
            return redirect()->route('report.dashboard')->with(['user' => $user]);
            // return redirect('http://127.0.0.1:8000')->with(['user' => $user]);
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah');
            // return redirect('http://127.0.0.1:8000')->with('failed', 'Email atau Password Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_prosess(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email|exists:employees,email',
            'password' => 'required|min:6'
        ]);



        $data['name'] = $request->nama;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        
        // User::create($data);

        // $login = [
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ];

        if (User::create($data)) {
            return redirect()->route('login');
        } else {
            return redirect()->route('reg')->with('failed', 'Email atau Password Salah');
        }
    }

    // public function cek(Request $request)
    // {
       

    //         dd(hash::make('123456789'));

        
    // }
}
