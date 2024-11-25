<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventUserBookingDetails extends Mailable
{
    use Queueable, SerializesModels;
    public $eventBooking;
    public $currentUser;
    public $resortOwner;
    public $event;

    public function __construct($eventBooking, $currentUser, $resortOwner, $event)
    {
        $this->eventBooking = $eventBooking;
        $this->currentUser = $currentUser;
        $this->resortOwner = $resortOwner;
        $this->event = $event;
    }

    public function build()
    {
        $email = $this->from($this->resortOwner->email)
                      ->view('emails.eventUserBookingDetails')
                      ->subject('New Event Booking Details')
                      ->with([
                          'eventBooking' => $this->eventBooking,
                          'user' => $this->currentUser,
                          'resortOwner'=>$this->resortOwner,
                          'event' => $this->event
                      ]);
        return $email;
    }

}
