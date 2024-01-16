<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);

        $user = User::create($attributes);
        // $this->pr($user);
        $UserProfile = UserProfile::create([
          'user_id' => $user->id,
          'vendor_id' => 99,
        ]);
        // exit;
        auth()->login($user);
        
        return redirect('/dashboard');
    } 
    
}
