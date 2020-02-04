<?php

namespace App\Mail;

use App\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyPoliciesMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachments = Document::all();
        $email = $this->view('emails.policies');
        foreach ($attachments as $attachment) {
            $filepath = public_path('uploads/files/'.$attachment->name);
            $fileParameters = [
                'as'   => $attachment->name,
                'mime' => 'application/pdf',
            ];
            $email->attach($filepath, $fileParameters);
        }

        return $email;
    }
}
