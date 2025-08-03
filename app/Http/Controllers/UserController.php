<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request) {
        $requestedInfo = $request->validate([
            'name' => ['required', 'min:3', 'max:10'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        $requestedInfo['password'] = bcrypt($requestedInfo['password']);
        User::create($requestedInfo);

        return 'Hello from controller!';
    }
}
