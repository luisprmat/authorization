<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.passwords.change');
    }

    public function change(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);

        $data = $request->only('password');

        $user = auth()->user();

        $user->password = bcrypt($data['password']);

        $user->save();

        return redirect('/home')->with('status', trans('passwords.changed'));
    }
}
