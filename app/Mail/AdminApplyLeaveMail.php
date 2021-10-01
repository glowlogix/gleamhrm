<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminApplyLeaveMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $leave;
    private $employee;
    private $email;

    /**
     * Create a new message instance.
     *
     * @param $id
     * @param  string  $password
     * @param $type
     */
    public function __construct($leave, $employee, $email)
    {
        $this->leave = $leave;
        $this->employee = $employee;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)->view('emails.admin_leave_apply')
        ->with('employee', $this->employee)
        ->with('leave', $this->leave);
    }
}
