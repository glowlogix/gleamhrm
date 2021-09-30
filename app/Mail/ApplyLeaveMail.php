<?php

namespace App\Mail;

use App\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyLeaveMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $request;
    private $leave;
    private $employee_email;

    /**
     * Create a new message instance.
     *
     * @param $id
     * @param  string  $password
     * @param $type
     */
    public function __construct($request, $leave, $employee_email)
    {
        $this->request = $request;
        $this->leave = $leave;
        $this->employee_email = $employee_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $leaveEmployee = Employee::find($this->leave->employee_id);

        return $this->from($this->employee_email)->view('emails.leave_apply')
        ->with('request', $this->request)
        ->with('leaveEmployee', $leaveEmployee);
    }
}
