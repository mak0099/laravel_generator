<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth; 

class HomeController extends Controller
{ 
    public function home(){
        return view('dashboard');
    }
    public function getLoginPage(){
        $view = view('login');
        return $view;
    }
    public function attemptLogin(Request $request) {
        if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            return redirect()->route('dashboard');
        } else {
            Session::put('alert-danger', 'Invalid username or password');
            return redirect()->back();
        }
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
