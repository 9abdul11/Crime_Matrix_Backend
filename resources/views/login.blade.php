<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

</head>
<body>

@if(\Session::has('error'))
<p class="error">{{ \Session::get('error') }}</p>
@endif

<form action="{{ route('userLogin') }}" method="POST">
<h3>Login Here</h3>
    @csrf    
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Enter Email" id="email">        
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Enter Password" id="password">
    
    <button value="Login">Login</button>   
    <hr>
    
</form>
</body>
</html>
@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
    </ul>
@endif()

 
<!-- <div class="logocontainer">
    <img src="images/fyplogo.png" alt="">
    <h1>Crime Matrix</h1>
</div>
<div class="secondheading">
    <p>Login</p>
</div>
<div class="ptag">
    <p>Login with your email address to create and manage all crime data</p>
</div> -->
