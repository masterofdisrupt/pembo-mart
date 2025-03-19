<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Colour Title</title>
</head>

<body>
    <h1>{{ $title }}</h1>
    <br>
    <h2>{{ $date }}</h2>
    <br>
    <h3>ID = {{ $getRecord->id }}</h3>
    <br>
    <h3>Name = {{ $getRecord->name }}</h3>
    <br>
    <h3>Created At = {{ date('d-m-Y', strtotime($getRecord->created_at)) }}</h3>

</body>

</html>
