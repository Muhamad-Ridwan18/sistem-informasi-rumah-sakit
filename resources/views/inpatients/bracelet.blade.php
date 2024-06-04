<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelang Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            margin-left: 30%;
            padding: 0;
            display: flex;
            justify-content: center; /* Mengatur .bracelet di tengah halaman */
            align-items: center; /* Mengatur .bracelet di tengah halaman */
            width: 100%;
        }
        .bracelet {
            background-color: #fff; /* Warna latar belakang gelang */
            border: 2px solid #000;
            border-radius: 15px;
            padding: 20px;
            height: 90px;
            width: auto; /* Lebar otomatis */
            max-width: 350px; /* Batas lebar maksimum */
            display: flex; /* Menjadikan gelang berbentuk horizontal */
            justify-content: space-evenly; /* Menempatkan isi di ujung kiri dan QR code di ujung kanan */
            align-items: center; /* Mengatur vertikal center */
            position: relative;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        }
        .bracelet-content {
            text-align: left;
            margin-bottom: 20px;
            width: calc(100% - 90px); /* Adjusted width for QR code */
            float: left;
        }
        .bracelet-content p {
            margin: 5px 0;
        }
        .qr-code {
            float: right; /* Align QR code to the right */
            margin-left: 20px; /* Add some space between content and QR code */
        }
        .qr-code img {
            width: 90px;
            height: auto;
            border: 1px solid #000;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="bracelet">
        {{-- <h6>RSUD Upaya Sehat</h6> --}}
        <div class="bracelet-content">
            <p>Nama     : {{ $inpatient->patient->full_name }}</p>
            <p>Umur     : {{ \Carbon\Carbon::parse($inpatient->patient->birth_date)->age }} tahun</p>
            <p>Poli     : {{ $inpatient->patient->latestClinicName() }}</p>
            <p>Room     : {{ $inpatient->room_number }}</p>
        </div>
        <div class="qr-code">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(90)->generate($inpatient->patient->id)) !!}">
        </div>
    </div>
</body>
</html>
