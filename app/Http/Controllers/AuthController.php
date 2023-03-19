<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use App\Actions\Fortify\CreateNewUser;

use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller {
    
    public function registerView(Request $request) {
        return view("auth.register");
    }
    
    public function registerPost(Request $request) {
        $user = (new CreateNewUser)->create($request->all());

        auth()->login($user);

        return redirect()->route("index");
    }
    
    public function loginView(Request $request) {
        return view("auth.login");
    }
    
    public function loginPost(Request $request) {
        $data = $request->only("email", "password");

        if (auth()->attempt($data)) {
            return redirect()->route("index");
        } else {
            return redirect()->back()->withErrors(["msg", "Invalid login credentials"]);
        }
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("index");
    }
}
