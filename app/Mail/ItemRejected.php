<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemRejected extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $title;
    /**
     * @var
     */
    public $product;

    public $subject = 'Your item was rejected';

    /**
     * Create a new message instance.
     *
     * @param $product
     */
    public function __construct($product)
    {
        $this->name = $product->owner->name;
        $this->title = $product->title;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.item-rejected');
    }
}
