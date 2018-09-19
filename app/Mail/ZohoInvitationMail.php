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
    public $getPassword;    
    public $fname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data, $getPassword)
    {
<<<<<<< HEAD
       $data['password'] =  $getPassword;
       $this->fname = $data['fname'];
       $this->org_email = $data['org_email'];
       $this->password = $data['password'];
   }
=======
         $data['password'] =  $getPassword;
         $this->fname = $data['firstname'];
         $this->org_email = $data['org_email'];
        $this->password = $data['password'];
         
    }
>>>>>>> c20c5e38d3ee97b490800e6067225edba3ee08cc

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