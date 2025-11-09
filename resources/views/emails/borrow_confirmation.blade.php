<h2>Halo {{ $borrowing->user->name }},</h2>
<p>Kamu baru saja meminjam buku <strong>{{ $borrowing->book->title }}</strong>.</p>
<p><b>Tanggal Pinjam:</b> {{ $borrowing->borrow_date }}<br>
<b>Tenggat Pengembalian:</b> {{ $borrowing->return_deadline }}</p>
<p>Harap kembalikan buku sebelum tenggat waktu untuk menghindari denda keterlambatan.</p>
<p>Terima kasih,<br><strong>Perpustakaan Digital</strong></p>
