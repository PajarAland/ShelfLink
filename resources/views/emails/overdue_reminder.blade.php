<h2>Hai {{ $borrowing->user->name }},</h2>
<p>Peminjaman buku <strong>{{ $borrowing->book->title }}</strong> sudah melewati tenggat waktu pengembalian!</p>
<p><b>Tenggat:</b> {{ $borrowing->return_deadline }}</p>
<p>Segera kembalikan buku untuk menghindari denda tambahan.</p>
<p><strong>Perpustakaan Digital</strong></p>
