<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showQuit()
    {
        return view('auth.delete');
    }

    public function doQuit(Request $request)
    {
        $user = $request->user();
        $user->name = "Utilisateur supprimé";
        $user->email = null;
        $user->password = Hash::make("nopassword");
        $user->save();
        Auth::logoutOtherDevices("nopassword");
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
