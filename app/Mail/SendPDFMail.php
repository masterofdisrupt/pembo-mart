<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPDFMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $filePath;
    public $fileUrl;

    /**
     * Create a new message instance.
     *
     * @param mixed $user
     * @param string|null $filePath
     * @param string|null $fileUrl
     */
    public function __construct($user, ?string $filePath = null, ?string $fileUrl = null)
    {
        $this->user = $user;
        $this->filePath = $filePath;
        $this->fileUrl = $fileUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('email.send_document')
                      ->subject(config('app.name') . ', Send Document');

        if (!empty($this->fileUrl)) {
            $email->attach($this->fileUrl);
        } elseif (!empty($this->filePath)) {
            $email->attach($this->filePath);
        }

        return $email;
    }
}