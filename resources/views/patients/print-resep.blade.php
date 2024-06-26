<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.invoice-header {
    margin-bottom: 20px;
}

.hospital-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.address, .contact-info {
    margin-bottom: 10px;
}

.separator {
    border-top: 1px solid #ccc;
    margin: 20px 0;
}

.patient-details {
    margin-top: 30px;
}

.payment-details, .total-amount {
    margin-top: 30px;
}

.total-amount {
    text-align: center;

}

.payment-table {
    width: 100%;
    border-collapse: collapse;
}

.payment-table th, .payment-table td {
    border: 1px solid #ccc;
    padding: 8px;
}

.total-price {
    font-size: 24px;
    font-weight: bold;
}

.footer {
    margin-top: 30px;
    text-align: center;
    font-style: italic;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="invoice-header">
                <div class="hospital-name">Rumah Sakit Upaya Sehat</div>
                <div class="address">Kabupaten Sorong Papua Barat</div>
                <div class="contact-info">Telp: 123-456-789 | Email: rsupayasehat@gmail.com</div>
                <div class="invoice-info">
                    <div>Tanggal: {{ $dateNow }}</div>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <div class="patient-details">
            <h2>Informasi Pasien</h2>
            <div class="patient-info">
                <div><strong>Nama:</strong> {{ $medicalExamination->patient->full_name }}</div>
                <div><strong>Nomor RM:</strong> {{ $medicalExamination->patient->medical_record_number }}</div>
                <div><strong>Doctor:</strong> {{ $medicalExamination->doctor->full_name }}</div>
            </div>
        </div>
        <div class="separator"></div>
        <div class="payment-details">
            <h2>Detail Resep</h2>
            {!! $medicalExamination->prescription !!}
        </div>
        <div class="separator"></div>
        
        <div class="footer">
            Terima kasih atas kunjungan Anda.
        </div>
    </div>
</body>
</html>
