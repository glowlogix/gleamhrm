<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SlackInvitationMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    public $data;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->name = $data['firstname'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Slack Invitation')
         ->view('emails.slackmail', ['name' => $this->name]);
    }
}
