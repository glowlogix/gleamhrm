<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveStatusMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $leave;
    private $employee;

    /**
     * Create a new message instance.
     *
     * @param $id
     * @param  string  $password
     * @param $type
     */
    public function __construct($leave, $employee)
    {
        $this->leave = $leave;
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.leave_status')
        ->with('leave', $this->leave)
        ->with('employee', $this->employee);
    }
}
