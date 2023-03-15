<?php

return [
    'skeleton_api_url' => env('LOGIN_URL', 'https://symfony-skeleton.q-tests.com/api/v2/'),
    'api_login_username' => env('LOGIN_USERNAME', 'ahsoka.tano@q.agency'),
    'api_login_password' => env('LOGIN_PASSWORD', 'Kryze4President'),
    'default_user_role' => env('DEFAULT_USER_ROLE', 'user'),
    'default_token' => env('DEFAULT_TOKEN'),
    'default_refresh_token' => env('DEFAULT_REFRESH_TOKEN')
];
