<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pengembalian Buku</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Konfirmasi Pengembalian Buku</h2>
    <p>Halo {{ $borrowing->user->name }},</p>

    <p>
        Kami telah menerima permintaan pengembalian buku:
        <br><strong>{{ $borrowing->book->title }}</strong>
        <br>Dipinjam pada: {{ \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d F Y') }}
    </p>

    <p>Status saat ini: <strong>Pending</strong> — menunggu konfirmasi dari admin.</p>

    <p>Terima kasih telah meminjam di perpustakaan kami.</p>

    <hr>
    <p style="font-size: 12px; color: #777;">
        Email ini dikirim otomatis oleh sistem perpustakaan digital.
    </p>
</body>
</html>
