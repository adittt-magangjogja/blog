<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px;">
    <h2>Pesan Baru dari Formulir Kontak Blog</h2>
    <p>Anda menerima pesan baru dari pengunjung:</p>
    <ul>
        <li><strong>Nama:</strong> {{ $data['name'] }}</li>
        <li><strong>Email:</strong> {{ $data['email'] }}</li>
    </ul>
    <h3>Pesan:</h3>
    <p style="background: #f9f9f9; padding: 15px; border-left: 4px solid #2563eb; white-space: pre-wrap;">{{ $data['message'] }}</p>
    <hr>
    <p style="font-size: 12px; color: #666;">Email ini dikirim otomatis dari sistem Blog.</p>
</body>
</html>
