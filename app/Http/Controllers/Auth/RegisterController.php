<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginData;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helper\ApiLogin;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $ApiData = ApiLogin::instance()->makeCall('users', 'POST', ApiLogin::instance()->useDefaultToken(), json_encode([
            'email' => $data['email'],
            'roles' => [
                'user'
            ],
            'password' => $data['password'],
            'first_name' => $data['name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'active' => true
        ]));

        $AccessCredentials = ApiLogin::instance()->requestToken($data['email'], $data['password']);

         DB::transaction(function () use ($data, $ApiData, $AccessCredentials) {
            User::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'gender' => $data['gender'],
                'active' => $ApiData->active ? 1 : 0,
                'roles' => config('appconfig.default_user_role'),
                'login_token' => $ApiData->login_token,
                'password_reset_token' => $ApiData->password_reset_token,
                'email_confirmed' => $ApiData->email_confirmed ? 1 : 0
            ]);

            LoginData::create([
                'user_id' => DB::getPdo()->lastInsertId(),
                'access_token' => $AccessCredentials->token_key,
                'refresh_token' => $AccessCredentials->refresh_token_key,
                'expires_at' => date('Y-m-d H:i:s', strtotime($AccessCredentials->expires_at)),
                'refresh_expires_at' => date('Y-m-d H:i:s', strtotime($AccessCredentials->refresh_expires_at)),
                'last_active_date' => date('Y-m-d H:i:s', strtotime($AccessCredentials->last_active_date)),
                'created_at' => $AccessCredentials->created_at,
                'updated_at' => $AccessCredentials->updated_at
            ]);
        });

         return User::latest()->first();
    }
}
