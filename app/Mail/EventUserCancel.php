<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventUserCancel extends Mailable
{
    use Queueable, SerializesModels;

    public $reason;
    public $event;
    public $resortOwner;
    public $booking;
    public function __construct($booking, $event, $resortOwner, $reason)
    {
        $this->booking = $booking;
        $this->event = $event;
        $this->resortOwner = $resortOwner;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->from($this->booking->email)
            ->view('emails.eventUserCancel')
            ->with([
                'event' => $this->event,
                'resortOwner' => $this->resortOwner,
                'reason' => $this->reason

            ])

            ->subject('Booking Event Cancelled');
    }
}
