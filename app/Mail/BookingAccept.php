<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingAccept extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $user;
    public $resortOwner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $user, $resortOwner)
    {
        $this->booking = $booking;
        $this->user = $user;
        $this->resortOwner = $resortOwner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->resortOwner->email) // Use resort owner's email as the sender
                    ->view('emails.bookingAccept') // Email template
                    ->subject('Your Booking was Accepted') // Corrected subject line
                    ->with([
                        'booking' => $this->booking,
                        'user' => $this->user,
                        'resortOwner' => $this->resortOwner,
                    ]);
    }
}
