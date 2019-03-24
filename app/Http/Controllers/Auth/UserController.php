<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return view('users.show', compact('user'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $new_name = $request->input('name');
        if (User::where('name', 'ILIKE', $new_name)->where('id', '!=', $user->id)->exists()) {
            return redirect('/account/edit')
                ->withInput()
                ->withErrors(["name" => "Ce pseudonyme est déjà utilisé. Merci d'en choisir un autre."]);
        }
        $user->name = $new_name;
        $user->save();
        return view('users.show', compact('user'));
    }

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
