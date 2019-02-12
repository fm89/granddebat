<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $questionRepository;
    private $responseRepository;

    public function __construct(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->responseRepository = $responseRepository;
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $question = $this->questionRepository->randomQuestion();
        $next_response = $this->responseRepository->randomResponse($question);
        return view('users.show', compact('user', 'next_response'));
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
