<?php

namespace App\Mail;

use App\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPasswordChange extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $employee_id;

    /**
     * Create a new message instance.
     *
     * @param $id
     * @param string $password
     * @param $type
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
        $employee = Employee::find($this->employee_id);

        return $this->view('emails.email_password_change')
        ->with('employee', $employee);
    }
}
