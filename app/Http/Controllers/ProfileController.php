<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => ['required', 'string', 'max:255', 'min:2', 'unique:users,login,' . \Auth::user()->id],
        ]);
    }

    protected function validatorPassword(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:1', 'confirmed']
        ]);
    }

    protected function editProfile(Request $request)
    {
        // $this->validator($request->all())->validate();

        $user = \Auth::user();

        $user->update([
            // 'login' => $request->login,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
        ]);
    }

    protected function editPassword(Request $request)
    {
        $this->validatorPassword($request->all())->validate();

        $user = \Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);
    }

    public function profileStatus()
    {
        return view('profile', []);
    }

    public function showEditProfile()
    {
        $user = \Auth::user();
        return view('edit_profile', ["user" => $user]);
    }

    public function showEditPassword()
    {
        $user = \Auth::user();
        return view('edit_password', ["user" => $user]);
    }
}
