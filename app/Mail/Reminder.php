<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
    }

    public function build()
    {
        return $this->from('HR@glowlogix.com')->view('emails.welcome');
    }
}
