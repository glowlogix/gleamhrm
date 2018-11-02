<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
<b>Hi {{$employee->firstname}} {{$employee->lastname}}</b>,
<br>

<p>Your account has been Updated
</p>
Email:{{$employee->official_email}}
<br>
@if($password!='')
    <br>Your New Password: {{$password}}
@endif
<br>
<br>
Note: If is there any problem the contact hr@glowlogix.com.
<br>
</body>
</html>