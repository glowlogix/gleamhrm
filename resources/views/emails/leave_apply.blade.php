<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <b>Hi</b>,
    <br>

    <p>New leave by <b>{{$leaveEmployee->firstname}} {{$leaveEmployee->lastname}}</b> is applied from date <b>{{$request->datefrom}}</b> to <b>{{$request->dateto}}</b>. Please review and submit your decision.</p>

    <p>Thank You.</p>
</body>

</html>