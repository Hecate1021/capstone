<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Rating</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .review-box {
            background-color: white;
            width: 320px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .review-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .review-box h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        .review-box p {
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .stars {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .star {
            font-size: 28px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .star:hover {
            transform: scale(1.2);
        }

        .star.filled {
            color: #ffc107;
        }

        .review-input {
            position: relative;
            margin-top: 10px;
        }

        .review-input textarea {
            width: 100%;
            height: 70px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            resize: none;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .review-input textarea:focus {
            outline: none;
            border-color: #ffc107;
        }

        .review-input .attachment-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #bbb;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .review-input .attachment-icon:hover {
            color: #ffc107;
        }

        button {
            margin-top: 20px;
            width: 100%;
            background-color: #ffc107;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 193, 7, 0.4);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="review-box" id="reviewForm">
        <form action="{{ route('reviews.submit', $booking->id) }}" method="POST">
            @csrf
            <input type="hidden" name="room_id" value="{{ $booking->room->id }}" required>
            <input type="hidden" name="booking_id" value="{{ $booking->id }}" required>
            <input type="hidden" name="resort_id" value="{{ $booking->resort->id }}" required>
            <input type="hidden" name="user_id" value="{{ $booking->user_id }}" required>
            <h3>How is your Experience?</h3>
            <p>Please take a moment to rate and review...</p>

            <!-- Hidden rating input -->
            <input type="hidden" name="rating" id="rating-input" required>

            <!-- Star rating -->
            <div class="stars">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>

            <div class="review-input">
                <textarea name="review" placeholder="Type your review..." required></textarea>
                <span class="attachment-icon">&#128247;</span>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    @if(session('review_success'))
    <div id="reviewSuccessModal" class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="modal-content bg-white p-6 rounded shadow-lg">
            <h3 class="text-center text-lg font-semibold text-green-600">Thank you for your review!</h3>
            <p class="text-center">We appreciate your feedback.</p>
            <button id="closeModal" class="block mx-auto mt-4 bg-green-500 text-white px-4 py-2 rounded" onclick="window.close()">Close</button>
        </div>
    </div>

    <script>
        // Hide the review form
        document.getElementById('reviewForm').classList.add('hidden');

        // Show the modal after submission
        document.getElementById('reviewSuccessModal').classList.remove('hidden');

        // Close the modal when the close button is clicked
        document.getElementById('closeModal')?.addEventListener('click', function() {
            document.getElementById('reviewSuccessModal').classList.add('hidden');
        });
    </script>
    @endif

    <script>
        // Select all stars and the hidden rating input
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating-input');

        // Loop through each star to add click and hover event listeners
        stars.forEach((star, index) => {
            // Handle click event
            star.addEventListener('click', () => {
                // Clear all stars
                stars.forEach((s) => s.classList.remove('filled'));

                // Fill stars up to the clicked one
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.add('filled');
                }

                // Update the hidden rating input value
                ratingInput.value = index + 1;
            });

            // Handle mouseover (optional hover effect)
            star.addEventListener('mouseover', () => {
                // Temporarily fill stars up to the hovered one
                stars.forEach((s, i) => s.classList.toggle('filled', i <= index));
            });

            // Handle mouseout (reset to the clicked rating)
            star.addEventListener('mouseout', () => {
                // Reset the stars to reflect the current rating input value
                const currentRating = ratingInput.value;
                stars.forEach((s, i) => s.classList.toggle('filled', i < currentRating));
            });
        });
    </script>
</body>

</html>
