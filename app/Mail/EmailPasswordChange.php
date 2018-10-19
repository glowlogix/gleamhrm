<?php

namespace App\Mail;

use App\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailPasswordChange extends Mailable
{
    use Queueable, SerializesModels;
    private $employee_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->employee_id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $employee = Employee::find($this->employee_id );
        return $this->view('emails.email_password_change')
        ->with('employee', $employee);
    }
}
