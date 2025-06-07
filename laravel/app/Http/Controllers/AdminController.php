<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

        return redirect()->route('admin.login')->with('fail', 'Вы вышли из системы');
    }
    public function profileView(Request $request){
        $data = [
            'pageTitle' => 'Profile',
        ];
        return view('back.pages.profile', $data);
    }
}
