<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventResortBookingDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $resortOwner;
    public $eventBooking;
    public $user;
    public $event;


    public function __construct( $eventBooking,  $user, $resortOwner, $event)
    {
        $this->resortOwner = $resortOwner;
        $this->user = $user;
        $this->eventBooking = $eventBooking;
        $this->event = $event;
    }

    /**
     * Get the message envelope.
     */


    /**
     * Get the message content definition.
     */
    public function build()
    {
        $email = $this->from($this->eventBooking->email)
                      ->view('emails.eventResortBookingDetails')
                      ->subject('Your Booking Details')
                      ->with([
                          'eventBooking' => $this->eventBooking,
                          'user' => $this->user,
                          'resortOwner'=>$this->resortOwner,
                          'event' => $this->event
                      ]);
        return $email;
    }
}
