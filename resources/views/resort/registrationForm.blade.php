<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        @media print {
            @page {
                size: letter;
                margin: 0; /* No margins on print */
            }

            body, html {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                font-size: 12px;
            }

            .container {
                max-width: 100%;
                margin: 0 auto;
                padding: 0 64px; /* Approximately 2.24 cm on the left and right */
                box-sizing: border-box;
                page-break-inside: avoid;
            }

            h1, h2 {
                font-size: 16px;
            }

            .header-text {
                margin-bottom: 5px;
            }

            .section-title {
                font-weight: bold;
                margin: 10px 0 5px;
            }

            .info-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
            }

            .info-label {
                font-weight: bold;
            }

            .rooms label {
                display: inline-block;
                width: 100%;
                font-size: 12px;
                margin-bottom: 5px;
            }

            footer {
                font-size: 10px;
                margin-top: 10px;
            }

            .logo img {
                max-width: 120px;
            }
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            text-decoration: underline;
        }

        .header-text {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
        }

        .personal-info,
        .room-selection,
        .special-requests,
        .policies,
        .payment-info {
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
        }

        .rooms {
            margin-bottom: 10px;
        }

        .rooms label {
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .policies-list,
        .payment-list {
            list-style-type: none;
            padding-left: 0;
        }

        .policies-list li,
        .payment-list li {
            margin-bottom: 5px;
        }

        .signature-section {
            margin-top: 10px;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-width: 150px; /* Adjust the logo size as needed */
        }
        .underline {
    text-decoration: underline;
}
    </style>
</head>
<body>

<div class="container">
    <div class="logo">
        <img src="{{asset('images/balai-logo.jpg')}}" alt="Sa Balai Lake View Resort Logo">
    </div>

    <div class="header-text">
        <h2>"A Taste of Your Own Home - Where the Ambiance Always Feels Like Home"</h2>
        <h1>Registration Form</h1>
        <p>Please complete the form below to book your stay. All fields are required to ensure we meet your needs and preferences accurately.</p>
    </div>

    <div class="personal-info">
        <div class="section-title">Personal Information</div>
        <div class="info-row">
            <span class="info-label">Full Name:<u>{{$booking->name}}</u></span>
            <span class="info-label">Arrival Date:<u>{{$booking->check_in_date}}</u></span>
        </div>
        <div class="info-row">
            <span class="info-label">Contact Number: <u>{{$booking->contact_no}}</u></span>
            <span class="info-label">Departure Date:<u>{{$booking->check_out_date}}</u></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email Address:<u>{{$booking->email}}</u></span>
            <span class="info-label">Total # of Guests:<u>{{$booking->number_of_visitors}}</u></span>
        </div>
        <div class="info-row">
            <span class="info-label">Number of Nights:
            <span class="info-label"><u>
                {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date)) }}
            </u></span>
        </div>
    </div>


    <div class="room-selection">
        <div class="section-title">Room Selection</div>
        <p>Select your preferred accommodation. All options include free breakfast, entrance, and pool access.</p>
        <div class="rooms">
            @foreach($rooms as $room)
                <label style="display: flex; align-items: center;">
                    <input type="checkbox"
                           @if($room->id == $bookedRoomId) checked @endif
                           style="margin-right: 10px; accent-color: blue;">
                    {{ $room->name }}, {{ $room->description }}, {{ $room->capacity }} Pax, PHP {{ number_format($room->price, 2) }}/night
                </label>
            @endforeach
        </div>
    </div>

    <div class="special-requests">
        <div class="section-title">Special Requests</div>
        <p>Please specify any special requests or accommodations needed (e.g., dietary restrictions, room location):</p>
        <div>_____<u>{{$booking->request}}</u>_________</div>
    </div>

    <div class="policies">
        <div class="section-title">Policies Acknowledgement</div>
        <ul class="policies-list">
            <li>● Cancellation Policy: Cancellations must be made 48 hours before the scheduled arrival to avoid a one-night stay charge.</li>
            <li>● Check-In Time: 2 PM | Check-Out Time: 11 AM. Requests for early check-in or late check-out are subject to availability and may incur additional charges.</li>
        </ul>
    </div>

    <div class="payment-info">
        <div class="section-title">Payment Information</div>
        <ul class="payment-list">
            <li>❑ Payment upon arrival</li>
            <li>❑ Online payment</li>
        </ul>
    </div>

    <div class="signature-section">
        <p>I hereby acknowledge and accept the terms and conditions, including the cancellation policy, check-in/out times, and payment method selected.</p>
        <div class="info-row">
            <span class="info-label">Signature: _________________________</span>
            <span class="info-label">Date:<span class="underline">{{ date('F j, Y') }}</span>


        </div>
    </div>

    <footer>
        <p>Thank you for choosing Sa Balai Lake View Resort, "A Taste of Your Own Home". We are committed to providing you with a memorable and enjoyable stay.</p>
    </footer>
</div>

</body>
</html>
