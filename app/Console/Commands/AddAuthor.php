<?php

namespace App\Console\Commands;

use App\Events\AuthorsFetched;
use Illuminate\Console\Command;

class AddAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to add new author';

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
        $authorFirstName = $this->ask('Enter The Author First name?');
        $authorLastName = $this->ask('Enter The Author Last name?');
        $authorBirthday = $this->ask('Enter The Author date of Birth YYYY-MM-DD?');
        $authorBiography = $this->ask('Enter Author Biography, max length 255');
        $authorGender = $this->choice('Enter Author gender?', ['male', 'female']);
        $authorPlaceOfBirth = $this->ask('The Author place of birth?');

        if($this->confirm('Do you wish to send now?')){
            event(new AuthorsFetched([
                'authorFirstName' => $authorFirstName,
                'authorLastName' => $authorLastName,
                'authorBirthday' => $authorBirthday,
                'authorBiography' => $authorBiography,
                'authorGender' => $authorGender,
                'authorPlaceOfBirth' => $authorPlaceOfBirth,
            ]));

            return $this->info('Author has been successfully created!!');
        };

        $this->info('Author creation has been cancelled!!');
    }
}
