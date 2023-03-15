<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helper\ApiLogin;

class AddAuthorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $body;
    public $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($body, $userId)
    {
        $this->body = $body;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ApiLogin::instance()->makeCall('books', 'POST', ApiLogin::instance()->getToken($this->userId), json_encode($this->body, JSON_NUMERIC_CHECK));
    }
}
