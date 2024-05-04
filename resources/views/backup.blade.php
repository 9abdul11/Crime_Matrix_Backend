<!-- resources/views/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/search.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />    
</head>
<body>    
@extends('layout')

@section('main-section')
<section class='nav-heading'>
    <div class="navbar-content">
      <div class="logo">
        <img class="logoimg" src="images/fyplogo.png" alt="" />
      </div>
      <nav>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#search">Search</a>
        <a href="#alerts">Alerts</a>
        <a href="#tip">Tip</a>       
        <button  class='btn' onClick="searchCrime()"><a href="register">Sign Up</a></button>
      </nav>
    </div>
   </section>
    
    
    <div class="mapmain">
    <div id="crime-section">
    <div id="crime-table">
    <div class="input-box">
      <i class="uil uil-search"></i>
      <input type="text" id="search-location" name="search-location" placeholder="search location"" />
      <button class="button" onClick="searchCrime()" >Search</button>
    </div>
    <div id="Crime-Table" style="display: none;">
    <h5 id="crime-table-heading"></h5>
    <div class="table-wrapper">
    <table id="crime-data" class="fl-table">
        <thead>
            <tr>
                <th>Crime Type</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
</div>
    </div>
    <div id="map-container">
        <div id="map" style="height: 100vh;"></div>
    </div>
</div>
    <script>
    var map;
    var markers = [];
    var highlightedPolygon;
    
    function initMap() {
        console.log("initMap executed");
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 31.5204, lng: 74.3587 },
            zoom: 12
        });
        drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        polygonOptions: {
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            strokeWeight: 2,
            clickable: false,
            editable: false,
            zIndex: 1
        }
    });

    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
        if (event.type === 'polygon') {
            // Clear existing polygon
            clearHighlightedPolygon();

            // Set the newly drawn polygon as the highlighted polygon
            highlightedPolygon = event.overlay;
        }
    });
    }

    var highlightedArea;
    
    function searchCrime() {
    console.log("searchCrime executed");

    var searchLocationInput = document.getElementById('search-location');
    var searchLocation = searchLocationInput.value.trim();
    document.getElementById('crime-table-heading').innerText = 'Crime Statistics by Type in ' + searchLocation;

    // Fetch crime data from Laravel based on the location
    fetch('/get-crimes-by-location?location=' + encodeURIComponent(searchLocation))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Clear existing markers
            clearMarkers();

            // Add markers for the new crime data
            data.forEach(crime => {
                var marker;

                // Customize marker based on crime type
                switch (crime.type.toLowerCase()) {
                    case 'burglary':
                        var marker = createMarker(crime, '{{ asset("icons/burglary.png") }}');
                        break;
                    case 'robbery':
                        marker = createMarker(crime, '{{ asset("icons/robbery.png") }}');
                        break;
                    case 'fight':
                        marker = createMarker(crime, '{{ asset("icons/assault.png") }}');
                        break;
                    case 'assault':
                        marker = createMarker(crime, '{{ asset("icons/assault.png") }}');
                        break;
                    case 'mobile_snatching':
                        marker = createMarker(crime, '{{ asset("icons/robbery.png") }}');
                        break;
                    case 'homicide':
                        marker = createMarker(crime, '{{ asset("icons/assault.png") }}');
                        break;
                    case 'sexual_assault':
                        marker = createMarker(crime, '{{ asset("icons/other.png") }}');
                        break;
                    case 'hit_and_run':
                        marker = createMarker(crime, '{{ asset("icons/vandalism.png") }}');
                        break;
                    default:
                        marker = createMarker(crime, '{{ asset("icons/red-dot.png") }}');
                        break;
                }

                markers.push(marker);
            });

            if (markers.length > 0) {
                var bounds = new google.maps.LatLngBounds();
                markers.forEach(marker => {
                    bounds.extend(marker.getPosition());
                });
                map.fitBounds(bounds);
                var highlightArea = new google.maps.Rectangle({
                    bounds: bounds,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    strokeWeight: 2,
                    clickable: false,
                    editable: false,
                    zIndex: 1,
                    map: map
                });

                // Clear the highlighted polygon if it exists
                clearHighlightedPolygon();
                highlightedPolygon = highlightArea;
            }
            highlightArea();
            document.getElementById('Crime-Table').style.display = 'block';
            updateCrimeTable(data);           
        })
        .catch(error => console.error('Error fetching crime data:', error));
}
function highlightArea() {
    console.log("highlightArea executed");

    // Remove the previous highlighted area
    if (highlightedArea) {
        highlightedArea.setMap(null);
    }

    // Coordinates of the polygon vertices for the highlighted area
    // var polygonCoords = [
    //     { lat: 31.4697, lng: 74.2728 },
    //     // Add other vertices as needed
    // ];

    // Create a new polygon for the highlighted area
    highlightedArea = new google.maps.Polygon({
        paths: polygonCoords,
        strokeColor: '#FF0000',  // Border color
        strokeOpacity: 2,
        strokeWeight: 2,
        fillColor: '#FF0000',    // Fill color (optional)
        fillOpacity: 2
    });

    // Set the polygon on the map
    highlightedArea.setMap(map);

    // Optionally, adjust the map view to fit the highlighted area
    var bounds = new google.maps.LatLngBounds();
    polygonCoords.forEach(function (point) {
        bounds.extend(point);
    });
    map.fitBounds(bounds);
}

function createMarker(crime, iconPath) {
    console.log('Creating Marker for Crime:', crime);

    var marker = new google.maps.Marker({
        position: { lat: parseFloat(crime.latitude), lng: parseFloat(crime.longitude) },
        map: map,
        title: crime.type,
        icon: iconPath
    });

    var infoWindowContent = '<div>' +
        '<p><strong>Crime Type:</strong> ' + crime.type + '</p>' +
        '<p><strong>Address:</strong> ' + crime.location + '</p>' +
        '<p><strong>Time:</strong> ' + crime.time + '</p>' +        
        '</div>';

    console.log('Info Window Content:', infoWindowContent);

    var infoWindow = new google.maps.InfoWindow({
        content: infoWindowContent
    });

    marker.addListener('click', function () {
        console.log('Marker Clicked!');
        infoWindow.open(map, marker);
    });

    return marker;
}

function clearMarkers() {
    markers.forEach(marker => {
        marker.setMap(null);
    });

    markers = [];
}
function updateCrimeTable(data) {
    // Assuming data is an array of crime objects with a 'type' property
    var crimeTypes = {};

    data.forEach(crime => {
        var crimeType = crime.type.toLowerCase();
        crimeTypes[crimeType] = (crimeTypes[crimeType] || 0) + 1;
    });

    var tbody = document.getElementById('crime-data').getElementsByTagName('tbody')[0];
    tbody.innerHTML = '';

    for (var type in crimeTypes) {
        var row = tbody.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = type;
        cell2.innerHTML = crimeTypes[type];
    }
}
// function handleSignUpClick(){
//     // Redirect to the Laravel login page
//     window.location.href = 'http://127.0.0.1:8000/register';
//   };
// </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTXnohcGL0e0EIUr2v4jpEOOoDMKewEaM&libraries=drawing&callback=initMap"></script>
@endsection


</body>
</html>
