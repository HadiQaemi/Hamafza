<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordChangedEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function build()
    {
        return $this->view('emails.reset_password.password_changed')
            ->from(config('constants.APP_MESSAGE_EMAIL'))
            ->subject(config('constants.SiteTitle') . ' - ' . 'تغییر کلمه عبور')
            ->with('info', $this->info);
    }
}
