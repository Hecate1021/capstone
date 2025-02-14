<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Location Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        #map-container {
            position: relative;
            width: 100%;
            height: 100vh;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        #info-box {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            padding: 8px;
            border-radius: 6px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            font-size: 12px;
            max-width: 200px;
            text-align: center;
        }

        #track-btn {
            position: absolute;
            bottom: 20px;
            left: 10px;
            z-index: 1000;
            background: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        /* Styling for the Leaflet Routing Panel */
        .leaflet-routing-container {
            background: white !important;
            font-size: 12px !important;
            padding: 5px !important;
            border-radius: 8px !important;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2) !important;
            max-width: 180px !important;
            max-height: 200px !important;
            overflow-y: auto !important;
        }

        /* Hide on mobile */
        @media (max-width: 768px) {
            .leaflet-routing-container {
                display: none !important;
            }
        }


        #track-btn:hover {
            background: #0056b3;
        }

        @media (max-width: 600px) {
            #info-box {
                font-size: 10px;
                padding: 5px;
                max-width: 150px;
            }

            #track-btn {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>

<body>
    <div id="map-container">
        <div id="info-box">
            <h3>Route Info</h3>
            <p id="distance">Getting location...</p>
        </div>

        <div id="map"></div>
    </div>

    <script>
        var resortLat = {!! json_encode($latitude) !!};
        var resortLng = {!! json_encode($longitude) !!};

        var map = L.map('map').setView([resortLat, resortLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var resortMarker = L.marker([resortLat, resortLng]).addTo(map)
            .bindPopup("Resort Location").openPopup();

        var userMarker;
        var routeControl;

        // Function to update user location and keep the map centered
        function updateLocation(position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;

            // Remove previous marker if exists
            if (userMarker) {
                map.removeLayer(userMarker);
            }

            // Add new marker for user location
            userMarker = L.marker([userLat, userLng]).addTo(map)
                .bindPopup("Your Location").openPopup();

            // Automatically move the map to follow the user
            map.setView([userLat, userLng], 15); // Adjust zoom level as needed

            // Remove previous route if exists
            if (routeControl) {
                map.removeControl(routeControl);
            }

            // Add routing control for navigation
            routeControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLat, userLng),
                    L.latLng(resortLat, resortLng)
                ],
                routeWhileDragging: true,
                createMarker: function() {
                    return null;
                }, // Prevent extra markers
                addWaypoints: false,
                show: false // Hide default panel
            }).addTo(map);

            // Update Distance Info
            var distance = getDistance(userLat, userLng, resortLat, resortLng);
            document.getElementById("distance").innerText = `Distance: ${distance.toFixed(2)} km`;
        }

        // Handle location errors
        function errorLocation() {
            alert("Could not get your location. Please enable GPS.");
        }

        // Calculate distance between two points (Haversine Formula)
        function getDistance(lat1, lon1, lat2, lon2) {
            var R = 6371;
            var dLat = (lat2 - lat1) * Math.PI / 180;
            var dLon = (lon2 - lon1) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        // Watch user's location and update automatically
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(updateLocation, errorLocation, {
                enableHighAccuracy: true,
                maximumAge: 0
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    </script>
</body>

</html>
