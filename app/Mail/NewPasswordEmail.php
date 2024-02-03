<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->data);
        return $this->subject('Raffle Login Password')
        ->view('emails.new-password')->with('data', $this->data)
        ->from('rs9613609@gmail.com');
    }
}
