@extends('design.header')

@section('content')
    @include('design.navbar')
    @include('design.sidebar')
    <div class="p-4 sm:ml-64 mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg dark:border-gray-700 dark:bg-gray-900">

            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4">Booking Calendar</h1>

                <div id="calendar" class="bg-white shadow-md rounded-lg p-4"></div>
            </div>

            <!-- FullCalendar Scripts & Styles -->
            <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth', // Start in the month view
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth' // Remove list view buttons
                        },
                        events: @json($formattedBookings),
                        eventContent: function(info) {
                            // Customize how events are shown in the list
                            var title = info.event.title;
                            var room = info.event.extendedProps.room;
                            var user = info.event.extendedProps.user;
                            var color = info.event.extendedProps.color;
                            return {
                                html: `<div style="background-color:${color}; padding: 5px; border-radius: 4px; color: white;">
                                            <strong>${title}</strong><br>
                                       </div>`
                            };
                        }
                    });

                    calendar.render();
                });
            </script>
        </div>
    </div>
@endsection
