<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <!-- ... -->
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            @if($index !== 0)
            <tr>
                <td>{{ $row[0] }}</td>
                <td>{{ $row[1] }}</td>
                <!-- ... -->
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

</body>

</html>