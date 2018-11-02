<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Document;


class CompanyPoliciesMail extends Mailable
{
    use Queueable, SerializesModels;

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
        foreach($attachments as $attachment){
            $filepath = public_path('uploads/files/'.$attachment->name);
            $fileParameters = [
                'as' => $attachment->name,
                'mime' => 'application/pdf',
            ];
            $email->attach($filepath, $fileParameters);
        }
        return $email;
    }
}
