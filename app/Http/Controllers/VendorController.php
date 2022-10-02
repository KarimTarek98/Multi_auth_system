<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function loginPage()
    {
        return view('vendor.login');
    }

    public function vendorDashboard()
    {
        return view('vendor.index');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $checkData = Auth::guard('vendor')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if ($checkData)
        {
            return redirect()->route('vendor.dashboard')
                ->with('success', 'Vendor Login Successfully');
        }
        else
        {
            return redirect()->back()
                ->with('error', 'Invalid Credentials, try again');
        }
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();

        return redirect()->route('vendor.login_form')
            ->with('error', 'Vendor Logout Successfully');
    }

    public function register()
    {
        return view('vendor.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $vendor = Vendor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now()
        ]);

        if ($vendor)
        {
            return redirect()->route('vendor.login_form')
                ->with('error', 'You have now registered, Login to continue..');
        }
        else
        {
            return redirect()->back()
                ->with('error', 'Failed to register, try again later');
        }
    }
}
