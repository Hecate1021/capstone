<!doctype html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Alishah&display=swap" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.css"
        rel="stylesheet">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('images/SebuSavvy.png') }}" type="image/png">
    <title>SebuSavvy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/linericon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel/owl.carousel.min.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <!-- FullCalendar CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css" rel="stylesheet">

    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/locales-all.min.js"></script>





    <style>
        .owl-prev,
        .owl-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 8px;
            border-radius: 100%;
            font-size: 20px;
        }

        .owl-prev {
            left: 5px;
        }

        .owl-next {
            right: 5px;
        }

        .owl-prev:hover,
        .owl-next:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .hotel_img img {
            width: 100%;
            /* Ensures the image takes up the full width of its container */
            height: 280px;
            /* Fixes the height of the image */
            object-fit: cover;
            /* Ensures the image covers the entire area without distortion */
            border-radius: 10px;
            /* Adds a slight rounding to the corners */
        }

        .user-icon {
            display: flex;

            align-items: center;
            justify-content: center;
            width: 40px;
            /* Adjust the width and height for size */
            height: 40px;
            border-radius: 50%;
            /* Circular border */
            background-color: #f8f9fa;
            /* Light background color */
            border: 2px solid #ccc;
            /* Border color */
        }

        .user-icon i {
            font-size: 24px;
            /* Adjust the font size for the icon */
            color: #555;
            /* Icon color */
        }

        .chat-logo {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1000;
        }

        .chat-logo i {
            font-size: 24px;
            color: #fff;
        }

        .chat-logo:hover {
            background-color: #0056b3;
        }

        .unread-badge {
            margin-left: auto;
            /* Ensures the badge is pushed to the far right */
            font-size: 12px;
            /* Adjust the font size */
            width: 20px;
            /* Adjust the width of the badge */
            height: 20px;
            /* Adjust the height of the badge */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #chat-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: white;
            background-color: #0084ff;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Chat Modal Styling */
        .chat-modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            bottom: 80px;
            /* Align above the chat icon */
            right: 20px;
            width: 250px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1100;
        }

        /* chat style */
        .chat-logo {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1000;
        }

        .chat-logo i {
            font-size: 24px;
        }

        .chat-logo:hover {
            background-color: #0056b3;
        }

        /* Position the dropdown to appear above the chat logo */
        .chat-logo .dropdown-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 0;
        }

        .chat-logo .dropdown-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .chat-logo .dropdown-item:last-child {
            border-bottom: none;
        }

        .chat-logo .dropdown-divider {
            margin: 0;
        }

        @media (max-width: 768px) {

            /* Adjust the max-width value as needed for your mobile breakpoint */
            .chat-logo {
                display: none;
            }
        }
    </style>
    @stack('style')
</head>

<body>

    @yield('content')



    @stack('script')


    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('assets/js/stellar.js') }}"></script>
    <script src="{{ asset('assets/vendors/lightbox/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Select all file inputs with the "filepond" class
        const inputElements = document.querySelectorAll('.filepond');

        // Initialize FilePond on each input element
        inputElements.forEach(input => {
            FilePond.create(input);
        });

        // Set FilePond options globally
        FilePond.setOptions({
            server: {
                process: '/upload',
                revert: '/delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        $(document).ready(function() {
            // Initialize individual room image carousel
            $('.hotel_img.owl-carousel').owlCarousel({
                items: 1, // 1 image per slide in room image carousels
                loop: true,
                margin: 10,
                nav: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });

            // Check the number of room items
            var roomItems = $('.room-item');

            // If there are 4 or more room items, turn the entire row into a slider
            if (roomItems >= 4) {
                $('.room-slider').addClass('owl-carousel'); // Add owl-carousel class to the row container
                $('.room-slider').owlCarousel({

                    items: 4 // Display 4 room items in the slider
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('status') === 'profile-updated')
                toastr.success('Profile updated successfully!', 'Success');
            @endif
        });
    </script>
    <script></script>
    <!-- Add this at the end of your body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>
