<?php

namespace App\Mail;

use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public Trip $trip;
    public array $tickets;
    public array $names;

    public function __construct(Trip $trip, array $tickets, array $names)
    {
        $this->trip = $trip;
        $this->tickets = $tickets;
        $this->names = $names;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.email_subject'),
        );
    }

    public function content(): Content
    {
        $ticketData = [];
        foreach ($this->tickets as $i => $ticket) {
            $code = sprintf(
                'Ticket: %s. Origin: %s. Destination: %s. Passenger: %s. Date: %s. Seat: %s.',
                $this->trip->id,
                $this->trip->departure_city,
                $this->trip->arrival_city,
                $this->names[$i] ?? 'N/A',
                $this->trip->departure_date,
                $ticket->seat_number
            );

            $qrCode = base64_encode(
                QrCode::format('svg')
                    ->errorCorrection('H')
                    ->size(120)
                    ->margin(1)
                    ->generate($code)
            );

            $ticketData[] = [
                'trip'   => $this->trip,
                'seat'   => $ticket->seat_number,
                'name'   => $this->names[$i] ?? 'N/A',
                'folio'  => $ticket->folio,
                'qrCode' => $qrCode,
            ];
        }

        return new Content(
            view: 'emails.tickets',
            with: ['tickets' => $ticketData, 'today' => now()->format('d-m-Y')],
        );
    }
}
