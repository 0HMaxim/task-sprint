<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:admin {email}', function (string $email) {
    $user = User::where('email', $email)->first();

    if (! $user) {
        $this->error("User with email {$email} not found.");
        return 1;
    }

    $user->assignRole('admin');
    $this->info("User {$email} is now an admin.");
})->purpose('Assign the admin role to a user by email');
