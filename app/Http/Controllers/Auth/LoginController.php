<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request){
        $email = $request->email;
        $password =  $request->password;

        $rpta = Auth::attempt(['email' => $email, 'password' => $password, 'state' => 'A']);

        if ($rpta) {
            return response()->json([
                'authUser' => Auth::user(),
                'code'     => 200
            ]);
        }else{
            return response()->json([
                'code' => 401
            ]);
        }
    }
    
    public function logout(Request $request){
        Auth::logout();
    }
}
