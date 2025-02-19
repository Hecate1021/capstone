<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #34a853;
        }

        .top-right-link {
            text-align: right;
            margin-bottom: 20px;
        }

        .top-right-link a {
            color: #1a73e8;
            text-decoration: none;
            font-size: 12px;
        }

        .info-section {
            border-top: 1px solid #dcdcdc;
            padding-top: 20px;
        }

        .info-section div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .info-section div span {
            font-size: 14px;
        }

        .info-section div span:first-child {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-center p {
            color: #666;
            font-size: 14px;
        }

        .text-center .note {
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }

        .cancel-link {
            text-align: center;
            margin-top: 30px;
        }

        .cancel-link a {
            color: #1a73e8;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-green {
            background-color: #34a853;
            color: white;
            text-align: center;
            display: block;
            width: 100%;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-green:hover {
            background-color: #2b8b3d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-right-link"></div>

        <h2>Your Booking Has Been Accepted</h2>

        <div class="info-section">
            <div>
                <span>Name:</span>
                <span>{{ $booking->name }}</span>
            </div>
            <div>
                <span>Email:</span>
                <span>{{ $booking->email }}</span>
            </div>
            <div>
                <span>Contact Number:</span>
                <span>{{ $booking->contact_no }}</span>
            </div>
            <div>
                <span>No. of Guests:</span>
                <span>{{ $booking->number_of_visitors }}</span>
            </div>
            <div>
                <span>Special Request</span>
                <span>{{ $booking->request }}</span>
            </div>
            <div>
                <span>Check-In Date:</span>
                <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</span>
            </div>
            <div>
                <span>Check-Out Date:</span>
                <span>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</span>
            </div>

        </div>

        <div class="text-center">
            <p>Your booking has been accepted! We’re looking forward to hosting you at Sa Balai Lake View Resort.</p>
            <p class="note">(Please note: You should hear back from us within 5 hours. If you haven't received a
                confirmation, please contact our customer support team at 0800 5677 241.)</p>
        </div>

        <div class="cancel-link">
            <a href="{{ route('user.mybooking') }}">To cancel the booking, click here</a>
        </div>
    </div>
</body>

</html>
