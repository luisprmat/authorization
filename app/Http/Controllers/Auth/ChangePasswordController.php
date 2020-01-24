<?php

namespace App\Http\Controllers\Auth;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
=======
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
>>>>>>> 1d5281ab900854002804a9784ba6e812c6b5d386

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

<<<<<<< HEAD
        $user->password = Hash::make($data['password']);
=======
        $user->password = bcrypt($data['password']);
>>>>>>> 1d5281ab900854002804a9784ba6e812c6b5d386

        $user->save();

        return redirect('/home')->with('status', trans('passwords.changed'));
    }
}
