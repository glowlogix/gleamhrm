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
    private $approverEmployee;

    /**
     * Create a new message instance.
     *
     * @param $id
     * @param  string  $password
     * @param $type
     */
    public function __construct($request, $leave, $approverEmployee)
    {
        $this->request = $request;
        $this->leave = $leave;
        $this->approverEmployee = $approverEmployee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $leaveEmployee = Employee::find($this->leave->employee_id);

        return $this->view('emails.leave_apply')
        ->with('request', $this->request)
        ->with('approverEmployee', $this->approverEmployee)
        ->with('leaveEmployee', $leaveEmployee);
    }
}
