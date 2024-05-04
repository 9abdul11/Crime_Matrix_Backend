
<head>
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
</head>
<body>
<h1>Stay Up To Date with crimes in your area by choosing between daily or weekly updates via email!.Stay Aware,Stay Safe</h1>
<div class="wrapper">
    <h2>For Alerts </br>Sign Up</h2>
<form action="{{ route('userRegister') }}" method="POST">

    @csrf

    <div class="input-box">
    <input type="text" name="name" placeholder="Enter Name">
    </div>
    <div class="input-box">
    <input type="email" name="email" placeholder="Enter Email">
    </div>
    <div class="input-box">
    <input type="password" name="password" placeholder="Enter Password">
    </div>
    <div class="input-box">
    <input type="Password" name="password_confirmation" placeholder="Confirm Password">
    </div>
    <div class="policy">
        <input type="checkbox">
        <h3>I accept all terms & condition</h3>
    </div>
    <div class="input-box button">
    <input  class="submit" type="submit" value="Register" >
    </div>    
    <div>
    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
    </ul>
@endif()
    </div>
</form>
</div>
@if(\Session::has('success'))
<p style="color:green;">{{ \Session::get('success') }}</p>
@endif
<div class="signupdiv">
</div>
</body>