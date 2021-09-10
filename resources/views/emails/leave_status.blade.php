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
    @php $datefrom = explode(' ', $leave->datefrom); $dateto = explode(' ', $leave->dateto); @endphp
    <p>Your leave from <b>{{$datefrom[0]}}</b> to <b>{{$dateto[0]}}</b> is {{$leave->status}}.</p>

    <p>Thank You.</p>
</body>

</html>