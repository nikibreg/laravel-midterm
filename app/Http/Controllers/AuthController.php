<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(){
        return view('user.login');
    }

    public function postLogin(Request $request){
        $credentials = $request->except('_token');

        if(Auth::attempt($credentials)){
            return redirect()->route('home');
        } else {
            abort(403);
        }
    }

    public function register(){
        return view('user.register');
    }

    public function postRegister(Request $request){
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->isAdmin = $request->has('isAdmin');
        $user->save();

        return redirect('users/login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
