<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $reason;
    public $userEmail;
    public $userName;

    public $resortOwner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $resortOwner)
    {
        $this->booking = $booking;

        $this->resortOwner = $resortOwner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.booking_cancelled')
                    ->with([
                        'booking' => $this->booking,
                        'reason' => $this->reason,
                        'resortOwner' => $this->resortOwner,
                    ])
                    ->from($this->resortOwner)
                    ->subject('Booking Cancelled');
    }
}
