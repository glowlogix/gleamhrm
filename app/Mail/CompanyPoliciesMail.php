<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    
        $attachments = [
        public_path('\uploads\files\Termination and Resignation Policy 2.docx.pdf') => [
            'as' => 'Termination and Resignation Policy 2.pdf',
            'mime' => 'application/pdf',
        ],
    
        public_path('\uploads\files\Code_of_Conduct.pdf') => [
            'as' => 'Code_of_Conduct.pdf',
            'mime' => 'application/pdf',
        ]
    ];

        $email = $this->view('emails.policies');
        foreach($attachments as $filePath => $fileParameters){
            $email->attach($filePath, $fileParameters);
        }
        return $email;
    }
}
