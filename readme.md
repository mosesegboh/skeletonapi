TO RUN
-clone fork.
-cd into dir.
-composer install to install dependencies.
-Kindly replace the values in env.example file with details which will be emailed to you. You can replace with your 
own database if you want.
run php artisan key:regenerate to generate new new application key for the project.
-run php artisan serve.

PROCESSES
-I added Cache to some processes which I thought was necessary. Note that this is totally descretionary and could be
added in other areas but I chose to keep it minimal to avoid unecessary complexities.
-I implemented queue jobs for adding authors since this is such a task that can be queued to make application faster.
remember to run php artisan queue:work for the queue jobs to start working.
- there is a helper class under App\Helpers\ApiLogin with relevant functions for dealing with the API.
- run for schedules.

