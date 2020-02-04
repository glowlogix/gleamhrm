<?php

namespace App\Mail;

use App\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateAccount extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $employee_id;
    private $password;

    /**
     * Create a new message instance.
     *
     * @param $id
     * @param string $password
     * @param $type
     */
    public function __construct($id, $password = '')
    {
        $this->employee_id = $id;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $employee = Employee::find($this->employee_id);

        return $this->view('emails.updateaccount')
            ->with('employee', $employee)->with('password', $this->password);
    }
}
