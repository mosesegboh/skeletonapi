<?php

namespace App\Http\Controllers;

use App\Helper\ApiLogin;
use Illuminate\Support\Facades\Cache;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Cache::remember('authors', now()->addMinutes(60), function () {
            return ApiLogin::instance()->makeCall('authors', 'GET', ApiLogin::instance()->getToken());
        });

        return view('home')->with('data', $data);
    }
}
