<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function create(){
        return inertia('Auth/Login');
    }

    public function store(AuthRequest $request){
        $data = $request->validated();
        
        if(!Auth::attempt($data,true)){
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]); 
        }

        $request->session()->regenerate();
        return redirect()->intended();
    }

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listings.index');
    }
} 