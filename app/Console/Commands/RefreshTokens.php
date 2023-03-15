<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helper\ApiLogin;
use App\Models\LoginData;

class RefreshTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh the expired tokens for users periodically';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = LoginData::all();

        foreach ($users as $user) {
            ApiLogin::instance()->checkTokenExpiry($user->expires_at, $user->refresh_token, $user->user_id);
        }
    }
}
