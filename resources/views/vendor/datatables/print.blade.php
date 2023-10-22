<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print Table</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->


    <style>
        body {
            margin: 20px;

        }

        /* Tabel Dasar */
        .table-custom {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table-custom th,
        .table-custom td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        /* Tabel dengan Batas */
        .table-custom-bordered {
            border: 1px solid #ddd;
        }

        /* Tabel yang Lebih Padat */
        .table-custom-condensed {
            font-size: 12px;
        }

        /* Tabel Bergaris */
        .table-custom-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <table class="table-custom table-custom-bordered table-custom-condensed table-custom-striped">
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
