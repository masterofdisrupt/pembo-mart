<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 *
 */

class RegisteredEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $save;

    public function __construct($save)
    {
        $this->save = $save;
    }

    public function build()
    {
        return $this->markdown('emails.registered_email_mail')->subject(config('app.name') . ', Registered Mail Password Set');
    }
}
