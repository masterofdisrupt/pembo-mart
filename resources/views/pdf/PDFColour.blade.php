<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembo-mart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>

    <h2>www[dot]pembo-mart[dot]com</h2>
    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Created At</td>
        </tr>
        @foreach ($getRecord as $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
