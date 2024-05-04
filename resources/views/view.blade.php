<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>    
    <!-- Add this line in your Blade view file -->
    <link rel="stylesheet" href="{{ asset('/css/view.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body>
@extends('layout')

@section('main-section')
<div class="container-fluid">
        <div class="row">

            <!-- Left Container -->
            <div class="col-md-2 left-container" id="left">
                <div class="logo desktop-logo">
                    <img src="/images/xam.png" alt="logo">
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
            
            <!-- <div class="adminpanel p-4">
            <div class="header logout"><a href="/logout">Logout</a></div>
                <p>Admin
                <svg xmlns="http://www.w3.org/2000/svg" class="homesvg" width="25" height="25" fill="currentColor"class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                </svg></p>
                
            </div> -->
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
                <br>
                @if(session('loggedinmessage'))
                <div id="loggedinmessage" class="alert alert-success">{{session('loggedinmessage')}}</div>
                @endif
                <div class="row mycontainer">
                <h1 class="heading">Crime Data</h1>
                @if(session('message'))
                <div id="message" class="alert alert-success">{{session('message')}}</div>
                @endif
                @if(session('updatemessage'))
                <div id="updatemessage" class="alert alert-success">{{session('updatemessage')}}</div>
                @endif
                @if(session('deletemessage'))
                <div id="deletemessage" class="alert alert-success">{{session('deletemessage')}}</div>
                @endif
                @if(count($crimeData) > 0)
        <div class="tablediv">        
        <table class="table table-striped">
            <thead class="headcolor table-primary">
                <tr>
                    <th>Sr#</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Source</th>
                    <th>Time</th>
                    <th>Date</th>                    
                    <th>Action</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach($crimeData as $key=>$crime)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $crime->type }}</td>
                        <td>{{ $crime->location }}</td>
                        <td>{{ $crime->source }}</td>
                        <td>{{ $crime->time }}</td>
                        <td>{{ $crime->date }}</td>                        
                        <td class="btntd"><a href="{{ route('editCrime', ['crimeId' => $crime->id]) }}" class="editbtn"><li class="fas fa-pencil-alt"></li>Edit</a>
                        <a href="{{ route('deleteCrime', ['crimeId' => $crime->id]) }}" class="delbtn" onclick="return confirm('Are you sure you want to delete this crime?')"><li class="fas fa-trash-alt"></li>Delete</a>
                    </td>
                       
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
    @else
        <p>No crime data available.</p>
    @endif
            </div>
            </div>
        </div>
</div>
    </div>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTXnohcGL0e0EIUr2v4jpEOOoDMKewEaM&callback=initMap"></script>

    <script>
    // JavaScript to show the success message and hide it after 3 seconds
    document.addEventListener('DOMContentLoaded', function () {
        // var successMessage = document.getElementById('message');
        var loggedinmessage=document.getElementById('loggedinmessage');
        // successMessage.style.display = 'block'; // Show the message
        loggedinmessage.style.display='block';

        setTimeout(function () {
            // successMessage.style.display = 'none'; // Hide the message after 3 seconds
            loggedinmessage.style.display = 'none'; // Hide the message after 3 seconds
        }, 3000);
    });


    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.getElementById('message');
        successMessage.style.display = 'block'; // Show the message
        

        setTimeout(function () {
            successMessage.style.display = 'none'; // Hide the message after 3 seconds
            
        }, 3000);
    });
    document.addEventListener('DOMContentLoaded', function () {
        var updatemessage = document.getElementById('updatemessage');
        updatemessage.style.display = 'block'; // Show the message
        

        setTimeout(function () {
            updatemessage.style.display = 'none'; // Hide the message after 3 seconds
            
        }, 3000);
    });
    document.addEventListener('DOMContentLoaded', function () {
        var deletemessage = document.getElementById('deletemessage');
        deletemessage.style.display = 'block'; // Show the message
        

        setTimeout(function () {
            deletemessage.style.display = 'none'; // Hide the message after 3 seconds
            
        }, 3000);
    });

</script>


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
