<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>    
    <!-- Add this line in your Blade view file -->
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
@extends('layout')

@section('main-section')
<div class="container-fluid">
        <div class="row">

        <div class="col-md-2 left-container" id="left">
                <div class="logo desktop-logo">
                    <img src="/imageS/xam.png" alt="logo">
                    <hr>
                </div>
                <nav class="navbar navbar-expand-md ">
                    <div class="container-fluid justify-content-left">
                      <!-- <a class="navbar-brand" href="#">Navbar</a> -->
                      <div class="navbar-brand mobile-logo">
                        <img class="img-fluid" src="/images/xam.png" width="50" alt="C-Panel Logo">
                    </div>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse flex-column align-items-start" id="navbarNav">
                       <a href="/view" class="d-flex crimebtn {{ request()->is('view') ? 'active' : '' }}">
                       <i class="fas fa-database"></i>Crime Data
                                </a>

                                  <a href="/insert" class="crimebtn {{ request()->is('insert') ? 'active' : '' }}">
                                  <i class="fas fa-plus"></i>Insert Crime 
                                  </a>
                  
                              </div>
                      </div>
                    </div>
                  </nav>

            <!-- Right Container -->
            
            <div class="adminpanel p-4">
    <div class="dropdown">
        <a class="btn dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/images/profile.png" class="profile" alt="">{{ auth()->user()->name}}
        </a>
        <ul class="dropdown-menu bg-dark " aria-labelledby="profileDropdown">
            <li class="dropdown-item bg-dark text-light">
                <span class="username">{{ auth()->user()->name }}</span>
            </li>
            <li class="dropdown-item bg-dark text-light">
                <span class="useremail">{{auth()->user()->email}}</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-item bg-dark">
                <a href="/logout" class="logout">Logout</a>
            </li>
        </ul>
    </div>
</div>
            <div class="col-md-9 right-side_content">
                <div class="row mycontainer">
                <!-- <div class="header"><a href="/logout">Logout</a></div> -->
                <h1 class="heading">Add New Crime</h1>
                    <!-- form data -->
                    <div class="col-md-6 form">
        <form action="{{ route('addCrime') }}" method="POST">
            @csrf
            
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            


            <div class="row">
                <div class="col-sm-12">
                <label>Type</label><br>
                <select name="type" required>
                    <option value="" disabled selected>Select Crime Type</option>
                    <option value="burglary">Burglary</option>
                    <option value="robbery">Robbery</option>
                    <option value="fight">Fight</option>
                    <option value="murder">Murder</option>
                    <option value="mobile_snatching">Mobile Snatching</option>
                    <option value="homicide">Homicide</option>
                    <option value=" sexual_assault"> Sexual Assault</option>
                    <option value="hit_and_run">Hit-and-Run</option>                    
                    <option value="Car_accident">Car_accident</option>
                </select>
                </div>
                <div class="col-sm-12">
                    <label class="localtionlabel">Location</label><br>
                    <input type="text" name="location" id="location" required>
                </div>                                
                <div class="col-sm-12">
                    <label>Source</label><br>
                    <input type="text" name="source" placeholder="Source" required>
                </div>
                <div class="col-sm-12">
                    <label>Time</label><br>
                    <input type="time" name="time" placeholder="time" required>
                </div>
                <div class="col-sm-12">
                    <label>Date</label><br>
                    <input type="date" name="date" required>
                </div>
                
            </div>     
            <input type="hidden" id="latitude" name="latitude">       
            <input type="hidden" id="longitude" name="longitude">       
            <input type="hidden" id="ip" name="ip">       
            <div class="row">                        
                <div class="col-sm-4">                  
                    <input type="submit" class="btn-primary" >
                </div>                
            </div>    
            @if(Session::has('success'))
        <p style="color:green;">{{ Session::get('success') }}</p>
        @endif()  
    </form>
    </div>
    
    <div class="col-md-6 map">
        <div class="container mb-5">
        <button class="btn btn-success px-5 py-2 mb-1" style="margin-left:20px"  type="button" onclick="searchLocation()">Search</button>
        <!-- Correct the 'style' attribute to 'height'  -->
        <div id="map" style="width:600px; height:470px; margin-left:20px"></div>
    </div>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTXnohcGL0e0EIUr2v4jpEOOoDMKewEaM&libraries=places"></script>    
    <script>
    var map;
    var autocomplete;
    var to = 'location';
    var marker; // Declare a marker variable -->


     function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 31.5204, lng: 74.3587 },
            zoom: 10
        });

        // Initialize autocomplete on the location input field
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(to)), {
            types: ['geocode'],
        });

        // Add a click event listener to the map
        map.addListener('click', function (event) {
            var latitude = event.latLng.lat();
            var longitude = event.latLng.lng();

            // Create a LatLng object from the clicked coordinates
            var latLng = new google.maps.LatLng(latitude, longitude);

            // Use the Geocoder to get the address of the clicked location
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latLng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        // Extract the formatted address from the results
                        var formattedAddress = results[0].formatted_address;

                        // Set the location input field with the formatted address
                        document.getElementById('location').value = formattedAddress;

                        // Update the hidden latitude and longitude fields
                        document.getElementById('latitude').value = latitude;
                        document.getElementById('longitude').value = longitude;

                        // Remove the previous marker (if any)
                        if (marker) {
                            marker.setMap(null);
                        }

                        // Create and place a new marker at the clicked location
                        marker = new google.maps.Marker({
                            position: latLng,
                            map: map
                        });
                    }
                }
            });
        });
    }
    function searchLocation() {
        var locationInput = document.getElementById('location').value;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': locationInput }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var location = results[0].geometry.location;
                map.setCenter(location);
                map.setZoom(15); // You can adjust the zoom level as needed
                if (marker) {
                    marker.setMap(null);
                }
                marker = new google.maps.Marker({
                    map: map,
                    position: location
                });
                document.getElementById('latitude').value = location.lat();
                document.getElementById('longitude').value = location.lng();
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    } 
</script>
                    </div>
                </div>
            </div>
        </div>
</div>
    </div>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTXnohcGL0e0EIUr2v4jpEOOoDMKewEaM&callback=initMap"></script>

@endsection


</body>
</html>
    

<!-- 
$(document).ready(function(){
            var autocomplete;
            var to = 'location';
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(to)),{
                types:['geocode'],
            });

            google.maps.event.addListener(autocomplete,'place_changed',function(){

                var near_place = autocomplete.getPlace();

                jQuery("#latitude").val(near_place.geometry.location.lat() );
                jQuery("#longitude").val(near_place.geometry.location.lng() );

                $.getJSON("https://api.ipify.org/?format=json",function(data){

                    let ip = data.ip;
                    jQuery("#ip").val(ip);
                });
            });
        }); -->
