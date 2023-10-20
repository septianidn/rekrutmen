<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print Table</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{ resource_path('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 20px
        }
    </style>
</head>

<body>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
            @foreach ($data as $row)
                @if ($loop->first)
                    <tr>
                        @foreach ($row as $key => $value)
                            <th scope="col">{!! $key !!}</th>
                        @endforeach
                    </tr>
                @endif
        </thead>
        <tbody>
            <tr>

                @foreach ($row as $key => $value)
                    @if (is_string($value) || is_numeric($value))
                        <td scope="row">{!! $value !!}</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
