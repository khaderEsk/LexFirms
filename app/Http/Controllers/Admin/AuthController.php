<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login_view()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = [
            'userName' => $request->userName,
            'password' => $request->password
        ];
        if (auth()->guard('web')->attempt($credentials)) {
            $user = auth()->user();
            if($user->block == 1){
                return redirect()->route('admin.loginview')
                ->withErrors(['userName' =>'انت محظور']);
            }
            if ($user->hasRole('accounting')) {
                return redirect()->route('expense.all');
            }
            return redirect()->route('stage.index');
        } else {
            return redirect()->route('admin.loginview')
                ->withErrors(['userName' => 'بيانات الدخول غير صحيحة.'])
                ->withInput($request->only('userName'));
        }
    }

    public function logout()
    {
        auth()->logout();
        return view('login');
    }
}
