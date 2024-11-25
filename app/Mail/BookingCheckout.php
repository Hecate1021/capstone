<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCheckout extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $resortOwner;

    /**
     * Create a new message instance.
     *
     * @param $booking
     * @param $resortOwner
     */
    public function __construct($booking, $resortOwner)
    {
        $this->booking = $booking;
        $this->resortOwner = $resortOwner; // Set the entire resort owner object
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->resortOwner->email) // Set the sender's email to the resort owner's email
                    ->subject('Checkout Confirmation - Thank You for Staying With Us')
                    ->view('emails.booking_checkout')
                    ->with([
                        'booking' => $this->booking,
                        'resortOwner' => $this->resortOwner,
                    ]);
    }
}
