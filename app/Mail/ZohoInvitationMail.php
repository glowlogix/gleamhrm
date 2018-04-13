<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ZohoInvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $org_email;
    public $password;
    public $fname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
         $data['password'] = '@password';
         $this->fname = $data['fname'];
         $this->org_email = $data['org_email'];
        $this->password = $data['password'];
         
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Zoho Invitation')
                ->view('emails.zohomail',['name'=>$this->fname,'org_email'=>$this->org_email,'password'=>$this->password]);
    }
}
