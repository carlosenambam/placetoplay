<!DOCTYPE html>
<html>
<head>
    <title>Transacciones</title>
</head>
<body>

    <table>
        <thead>
            <th>ID local</th>
            <th>ID (PlaceToPay) </th>
            <th>CUS</th>
            <th>Descripción Estado</th>
            <th>Estado</th>
        </thead>
        <tbody>
            @foreach ($transactions as $tr) 
                <tr>
                    <td>{{ $tr->id }}</td>
                    <td>{{ $tr->transaction_id }}</td>
                    <td>{{ $tr->trazability_code }}</td>
                    <td>{{ $tr->response_reason_text }}</td>
                    <td>{{ $tr->state }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <style type="text/css">
        table, th, td {
            border: 1px solid #000;
        }
    </style>
</body>
</html>