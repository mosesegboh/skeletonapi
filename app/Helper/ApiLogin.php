<?php

namespace App\Helper;

use App\Models\LoginData;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApiLogin
{
    /**
     * Initial Login into API
     *
     * @return \App\Helpers\ApiLogin
     */
    public function login()
    {
        return $this->makeCall('token', 'POST', '', json_encode([
            'email' => config('appconfig.api_login_username'),
            'password' => config('appconfig.api_login_password')
        ]) );
    }

    /**
     * Request token for new user registration
     *
     * @param  string  $username
     * @param  string  $password
     * @return \App\Helpers\ApiLogin
     */
    public function requestToken($username, $password)
    {
        return $this->makeCall('token', 'POST', '', json_encode([
            'email' => $username,
            'password' => $password
        ]) );
    }

    /**
     * Save Initial/default token
     *
     * @return int
     */
    public function saveToken(): int
    {
        $loginData = $this->login();

        $login = LoginData::updateOrInsert(
            ['user_id' => Auth::id()],
            ['access_token' => $loginData->token_key,
                'refresh_token' =>  $loginData->refresh_token_key,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        if ($login)
            return 1;
        else
            return 0;
    }

    /**
     * Return token for making calls after user login and connected
     *
     * @return String
     */
    public function getToken($userId = ''): String
    {
        $user = LoginData::where('user_id', $userId ? $userId : Auth::user()->id )->first();

        return $user->access_token;
    }

    /**
     * Return default token for making calls before user login and connected
     *
     * @return String
     */
    public function useDefaultToken(): String
    {
        return config('appconfig.default_token');
    }

    /**
     * Request token for new user registration
     *
     * @param  string  $url_resource
     * @param  string  $method
     * @param  string  $token
     * @param  json  $body
     * @return json
     */
    public function makeCall($url_resource, $method, $token='', $body='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('appconfig.skeleton_api_url') . $url_resource,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    /**
     * Check if token has expired an refresh token for use before usage
     *
     * @param  DateTime  $expires_at
     * @param  String  $token
     * @param  String  $refreshToken
     * * @param  Int  $refreshToken
     * @return void
     */
    public function checkTokenExpiry($expiresAt, $refreshToken, $userId): void
    {
        $date = new DateTime();
        $targetDate = new DateTime($expiresAt);

        $date->modify('+1 day');

        if ($date >= $targetDate) {
            $usertokens = $this->makeCall('token/refresh/' . $refreshToken, 'GET', $refreshToken);

            LoginData::where('user_id', $userId)
            ->update([
                'access_token' => $usertokens->token_key,
                'refresh_token' => $usertokens->refresh_token_key,
                'expires_at' => date('Y-m-d H:i:s', strtotime($usertokens->expires_at)),
                'refresh_expires_at' => date('Y-m-d H:i:s', strtotime($usertokens->refresh_expires_at)),
                'last_active_date' => date('Y-m-d H:i:s', strtotime($usertokens->last_active_date)),
                'created_at' => $usertokens->created_at,
                'updated_at' => $usertokens->updated_at
            ]);
        }
    }

    /**
     * Returns and instance of the class for easy one line calls
     *
     * @return \App\Helpers\ApiLogin
     */
    public static function instance()
    {
        return new ApiLogin();
    }
}
