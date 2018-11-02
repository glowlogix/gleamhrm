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

    <p>Your account has been created on 
        <a href="{{URL::to('/')}}">HR portal</a>
        Please login using the given email address and Password
    </p>
        Email:{{$employee->official_email}}
    <br>
    <br> Password: {{$employee->password}}
    <br>
    Note: As soon as you log in change your password.
    <br> Best Luck,
</body>

</html>