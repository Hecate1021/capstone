<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Checkout Confirmation</title>
    <style>
        /* Reset Styles */
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f4f4f4;
        }

        /* Container */
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header */
        .email-header {
            background-color: #1a73e8;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }

        .email-header h2 {
            margin: 0;
            font-size: 24px;
        }

        /* Body */
        .email-body {
            padding: 30px;
            color: #333333;
        }

        .email-body p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section div {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-section div:last-child {
            border-bottom: none;
        }

        .info-section div span:first-child {
            font-weight: bold;
            color: #555555;
        }

        /* Footer */
        .email-footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {

            .email-body,
            .email-header,
            .email-footer {
                padding: 15px;
            }

            .info-section div {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-section div span {
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h2>Booking Checkout Confirmation</h2>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Dear {{ $booking->name }},</p>
            <p>Your booking for the event has been successfully checked out. Thank you for staying with us!</p>
            <h3 style="color: #1a73e8;">Event: {{ $booking->event->event_name }}</h3>

            <!-- Booking Details -->
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
                    <span>{{ $booking->contact }}</span>
                </div>
                <div>
                    <span>Payment:</span>
                    <span>₱{{ number_format($booking->payment, 2) }}</span>
                </div>
                <div>
                    <span>Resort:</span>
                    <span>Sa Balai Lake View Resort</span>
                </div>
            </div>

            <p>We hope you enjoyed your experience. If you have any feedback or questions, please feel free to reach out to our support team.</p>

            <!-- Note -->
            <div class="note" style="margin-top: 20px; color: #999999; font-size: 12px; text-align: center;">
                (For further assistance, please contact our customer support team at 0800 5677 241.)
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{$resortOwner->name}}. All rights reserved.</p>

        </div>
    </div>
</body>

</html>
