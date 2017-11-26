<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorPagesEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $logged_info;
    private $error_detail;

    public function __construct($logged_info, $error_detail="")
    {
        $this->logged_info = $logged_info;
        $this->error_detail = $error_detail;
    }

    public function build()
    {
        return $this->view('emails.page_error.' . $this->logged_info['error_code'])
            ->from('info@hamafza.ir')
            ->subject('هم‌افزا - ' . $this->logged_info['error_code'])
            ->with('logged_info', $this->logged_info)
            ->with('page', $this->logged_info['error_code'])
            ->with('error_detail', $this->error_detail);
    }
}
