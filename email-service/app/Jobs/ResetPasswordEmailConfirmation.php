<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmailConfirmation implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    public function __construct($email) {
        $this->email = $email;
    }

    public function handle() {
        var_dump('Sending reset password email confirmation');
        \Mail::send('reset_password_confirmation', ['email' => $this->email], function (Message $message) {
            $message->subject('Your password was changed');
            $message->to($this->email);
        });
        var_dump('Reset password email sent confirmation');
    }
}
