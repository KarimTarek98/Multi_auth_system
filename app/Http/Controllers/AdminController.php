<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');
    }

    public function dashboardPage()
    {
        return view('admin.index');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $dataCheck = Auth::guard('admin')->attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($dataCheck)
        {
            return redirect()->route('admin.dashboard')->with('success', 'Admin Login Successfully');
        }
        else
        {
            return back()->with('error', 'Invalid Credentials');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('error', 'Admin Logout Successfully');
    }

    public function register()
    {
        return view('admin.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('login_form')
            ->with('success', 'You are now new Admin, please login');
    }
}
