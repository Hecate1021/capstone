<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f7f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
        }
        h2 {
            color: #333;
        }
        .details {
            margin: 20px 0;
            border-top: 1px solid #e1e1e1;
            border-bottom: 1px solid #e1e1e1;
            padding: 10px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>The booking has been Cancelled by {{$booking->name}}</h1>
        <p><strong>Reason:{{$booking->reason}} </strong> </p>
        <p>The following booking details has been Cancelled </p>

        <div class="details">
            <h2>Booking Details</h2>
            <p><strong>Room Name:</strong> {{ $booking->room->name }}</p>
            <p><strong>Name:</strong> {{ $booking->name }}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Contact Number:</strong> {{ $booking->contact_no }}</p>
            <p><strong>Check In Date: </strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</p>
            <p><strong>Check In Out: </strong>{{ \Carbon\Carbon::parse($booking->check_in_out)->format('d M Y') }}</p>
            <p><strong>Total Payment:</strong> ₱{{ number_format($booking->payment, 2) }}</p>
        </div>

        {{-- <p>If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>

        <a href="mailto:{{ $resortOwner->email }}" class="button">Contact Resort Owner</a>

        <p>We would love to hear your feedback! Please take a moment to rate your stay:</p>

        <a href="{{ route('review.create', ['booking_id' => $booking->id]) }}" class="button">Rate Your Stay</a> --}}

        <p>We look forward to welcoming you back in the future!</p>

        {{-- <div class="footer">
            <p>Best regards,</p>
            <p>{{ $resortOwner->name }}</p>
            <p>{{ $resortOwner->email }}</p>
        </div> --}}
    </div>

</body>
</html>
