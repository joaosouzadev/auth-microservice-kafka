<?php

namespace App\Console\Commands;

use App\Jobs\WelcomeEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProduceCommand extends Command {
    protected $signature = 'produce';

    public function handle() {
        $user = User::make([
            'name' => 'test',
            'email' => 'jvms3d@gmail.com',
            'password' => Hash::make('123'),
            'confirmation_token' => Str::uuid()
        ]);

        WelcomeEmail::dispatch($user->toArray());
    }
}
