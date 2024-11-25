<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.6/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.6/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.6/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.6/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.6/main.min.js"></script>
    <style>
        #calendar {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'dayGrid', 'interaction' ],
                initialView: 'dayGridMonth',
                events: {
                    url: '{{ route('bookings.events') }}',
                    method: 'GET'
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                eventRender: function(info) {
                    if (info.event.extendedProps.color) {
                        info.el.style.backgroundColor = info.event.extendedProps.color;
                    }
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
