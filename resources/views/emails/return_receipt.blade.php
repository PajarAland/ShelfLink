<h2>Halo {{ $borrow->user->name }},</h2>

<p>Kami telah menerima pengembalian buku <strong>{{ $borrow->book->title }}</strong>.</p>

@if ($lateDays > 0)
    <p>Buku dikembalikan terlambat <strong>{{ $lateDays }} hari</strong> (Denda keterlambatan: Rp{{ number_format($lateFine, 0, ',', '.') }}).</p>
@endif

@if ($damageFine > 0)
    <p>Ada tambahan denda kerusakan sebesar Rp{{ number_format($damageFine, 0, ',', '.') }}.</p>
@endif

@if ($totalFine > 0)
    <p><strong>Total Denda: Rp{{ number_format($totalFine, 0, ',', '.') }}</strong></p>
@else
    <p>Tidak ada denda yang dikenakan. Terima kasih telah mengembalikan tepat waktu!</p>
@endif

<p>Semoga buku tersebut bermanfaat. Kami tunggu peminjaman berikutnya 😊</p>
<p><strong>Perpustakaan Ceria</strong></p>
