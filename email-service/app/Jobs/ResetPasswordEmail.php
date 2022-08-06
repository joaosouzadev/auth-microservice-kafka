<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $token;

    public function __construct($email, $token) {
        $this->email = $email;
        $this->token = $token;
    }

    public function handle() {
        var_dump('Sending reset password email');
        \Mail::send('reset_password', ['email' => $this->email, 'token' => $this->token], function (Message $message) {
            $message->subject('Reset your password');
            $message->to($this->email);
        });
        var_dump('Reset password email sent');
    }
}
