<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request){
        $requestedInfo = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);
        if (auth()->attempt(['name' => $requestedInfo['loginname'], 'password' => $requestedInfo['loginpassword']])) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect('/admin-view');
            }
            return redirect('/');
        }
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }
    public function register(Request $request) {
        $requestedInfo = $request->validate([
            'name' => ['required', 'min:3', 'max:10', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        $requestedInfo['password'] = bcrypt($requestedInfo['password']);
        $requestedInfo['role'] = 'user';
        $user = User::create($requestedInfo);

        auth()->login($user);
        return redirect('/');
    }
}
