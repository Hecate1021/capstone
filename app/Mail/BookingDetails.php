<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingDetails extends Mailable
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
    public function __construct($booking, $user, $resortOwner )
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
        $email = $this->from($this->resortOwner)
                      ->view('emails.booking_details')
                      ->subject('Your Booking Details')
                      ->with([
                          'booking' => $this->booking,
                          'user' => $this->user,
                      ]);



        return $email;
    }
}
