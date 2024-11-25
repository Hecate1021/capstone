<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingUserCancel extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $resortOwner;

    public function __construct($booking, $resortOwner)
    {
        $this->booking = $booking;
        $this->resortOwner = $resortOwner;
    }

    public function build()
    {
        return $this->from($this->booking->email) // Set the sender's email to the resort owner's email
        ->subject('The booking has been canceled')
        ->view('emails.bookingUser_cancelled')
        ->with([
            'booking' => $this->booking,
        ]);
    }
}
