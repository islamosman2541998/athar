<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        p {
            font-size: 12px;
        }

        .signature {
            font-style: italic;
        }
    </style>
</head>
<body>
<div>
    <h1>There is an new booking in Almanar</h1>

    <p> Name:  {{ $data['name'] }},</p>
    <p> Email:  {{ $data['email'] }},</p>
    <p> Mobile:  {{ $data['mobile'] }},</p>
    <p> Date:  {{ $data['date'] }},</p>
    <p> specialty name:  {{ $data['specialty_name'] }},</p>
    <p> Doctor name:  {{ $data['doctor_name'] }},</p>
    <p> Message:  {{ $data['message'] }},</p>
    
    <p class="signature">Almanar</p>
</div>
</body>
</html>