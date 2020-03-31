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

class EditProfileController extends Controller
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

    protected function validator_password(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:1', 'confirmed']
        ]);
    }

    protected function edit_profile(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = \Auth::user();

        $user->update([
            'login' => $request->login,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
        ]);
    }

    protected function edit_password(Request $request)
    {
        $this->validator_password($request->all())->validate();

        $user = \Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        /*      $this->validator($request->all())->validate();

        event(new UserRegistered($user = $this->create($request->all()))); */

        // $this->guard()->login($user);

        /* return $this->registered($request, $user)
            ?: redirect($this->redirectPath()); */
    }
}
