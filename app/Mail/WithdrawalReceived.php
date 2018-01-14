<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawalReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public $date;

    public $amount;

    public $subject = 'Withdrawal request received';

    /**
     * Create a new message instance.
     *
     * @param $withdrawal
     */
    public function __construct($withdrawal)
    {
        $this->amount = $withdrawal->amount;
        $this->name = $withdrawal->user->name;
        $this->date = $withdrawal->created_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.withdrawal-received');
    }
}
