<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrderCreated
 * @package App\Mail
 */
class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Order */
    public $order;

    /**
     * OrderDelivered constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.order-created');
    }
}
