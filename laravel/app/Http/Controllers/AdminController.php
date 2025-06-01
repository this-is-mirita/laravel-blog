<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function adminDashboard()
    {
        $data = [
            'pageTitle' => 'Admin Dashboard',
        ];
        return view('back.pages.dashboard', $data);

    }

    public function logoutHandler(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('fail', 'You have been logged out.');
    }
}
