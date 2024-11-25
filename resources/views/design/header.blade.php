<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sa Balai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
<script src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}" defer></script>


    <link
        href="
    https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.css
    "
        rel="stylesheet">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include Flatpickr Range Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>
    <!-- Include Flatpickr CSS for dark mode -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">


    @stack('style')
    <script src="https://unpkg.com/feather-icons"></script>
</head>
</head>

<body class=" text-gray-900 hide-scrollbar bg-gray-100">


    @yield('content')



    @stack('scripts')
</body>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js
"></script>
<script>
    // Wait for the DOM to fully load
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace()
        // Get all checkout buttons
        const checkoutButtons = document.querySelectorAll('.checkout-button');

        // Loop through each checkout button and attach click event listener
        checkoutButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-target');
                const modalElement = document.getElementById(modalId);

                // Check if modal element exists
                if (modalElement) {
                    const modal = new Modal(modalElement);
                    modal.open();
                } else {
                    console.error(`Modal with id ${modalId} not found.`);
                }
            });
        });
    });
</script>


<script>
    FilePond.registerPlugin(FilePondPluginMediaPreview);
    FilePond.registerPlugin(FilePondPluginImagePreview);

    FilePond.create(document.getElementById('postInput'));
    FilePond.create(document.getElementById('profilePhotoInput'));
    FilePond.create(document.getElementById('coverPhotoInput'));

    // Functions to Toggle Forms
    function showProfilePhotoForm() {
        document.getElementById('profilePhotoForm').classList.remove('hidden');
        document.getElementById('coverPhotoForm').classList.add('hidden');
    }

    function showCoverPhotoForm() {
        document.getElementById('profilePhotoForm').classList.add('hidden');
        document.getElementById('coverPhotoForm').classList.remove('hidden');
    }
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    FilePond.setOptions({
        server: {
            process: '/upload',
            revert: '/delete',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
    });
</script>
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datepicker-range-start", {
            altInput: true,
            altFormat: "m/d/Y",
            dateFormat: "m/d/Y",
            minDate: "today",

        });

        flatpickr("#datepicker-range-end", {
            altInput: true,
            altFormat: "m/d/Y",
            dateFormat: "m/d/Y",
            minDate: "today"
        });
    });
</script>




</html>
