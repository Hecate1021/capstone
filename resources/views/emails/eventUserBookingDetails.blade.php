<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        /* Reset Styles */
        body, html {
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
        /* Button */
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #34a853;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #2b8b3d;
        }
        /* Cancel Link */
        .cancel-link {
            text-align: center;
            margin-top: 20px;
        }
        .cancel-link a {
            color: #d93025;
            text-decoration: none;
            font-size: 14px;
        }
        .cancel-link a:hover {
            text-decoration: underline;
        }
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-body, .email-header, .email-footer {
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
            <h2>Booking Confirmation</h2>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Dear {{ $eventBooking->name }},</p>
            <p>Thank you for your booking! We are excited to confirm your reservation for the event:</p>
            <h3 style="color: #1a73e8;">Event: {{ $event->event_name }}</h3>

            <!-- Booking Details -->
            <div class="info-section">
                <div>
                    <span>Name:</span>
                    <span>{{ $eventBooking->name }}</span>
                </div>
                <div>
                    <span>Email:</span>
                    <span>{{ $eventBooking->email }}</span>
                </div>
                <div>
                    <span>Contact Number:</span>
                    <span>{{ $eventBooking->contact }}</span>
                </div>
                <div>
                    <span>Payment:</span>
                    <span>₱{{ number_format($eventBooking->payment, 2) }}</span>
                </div>
                <div>
                    <span>Resort:</span>
                    <span>Sa Balai Lake View Resort</span>
                </div>
            </div>

            <p>We are processing your booking. Please check your email for a booking confirmation from the resort.</p>
            <p>If you have any questions or need further assistance, feel free to reach out to our customer support team.</p>

            <!-- Action Button -->
            <div style="text-align: center;">
                <a href="{{ route('user.mybooking') }}" class="btn">View My Bookings</a>
            </div>

            <!-- Note -->
            <div class="note" style="margin-top: 20px; color: #999999; font-size: 12px; text-align: center;">
                (Please note, you should hear back within 5 hours. If you still haven't received a confirmation, please contact our customer support team at 0800 5677 241.)
            </div>

            <!-- Cancel Link -->
            <div class="cancel-link">
                <a href="{{ route('user.mybooking') }}">To cancel the booking, click here</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
            <p>If you no longer wish to receive these emails, you can <a href="#" style="color: #1a73e8; text-decoration: none;">unsubscribe here</a>.</p>
        </div>
    </div>
</body>
</html>
