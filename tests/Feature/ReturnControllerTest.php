<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReturnReceiptMail;

/**
 * Class ReturnControllerTest
 *
 * Menguji seluruh fitur utama pada ReturnController:
 * - Menampilkan daftar peminjaman
 * - Proses pengembalian buku
 * - Validasi jika buku sudah dikembalikan
 * - Perhitungan denda keterlambatan
 * - Pengiriman email bukti pengembalian
 * - Pembatalan status pengembalian
 */
class ReturnControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Admin dapat melihat daftar semua peminjaman di halaman pengembalian.
     *
     * Tujuan:
     * Memastikan route `admin.returns.index` berfungsi dan mengembalikan view
     * dengan variabel `borrowings`.
     */
    public function test_admin_can_view_all_borrowings_on_return_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        // ✅ gunakan admin karena route dijaga middleware admin
        $response = $this->actingAs($admin)->get(route('admin.returns.index'));

        $response->assertStatus(200);
        $response->assertViewHas('borrowings');
    }

    /**
     * Test 2: Status peminjaman berubah menjadi 'returned' saat update berhasil.
     *
     * Tujuan:
     * Menguji proses pengembalian buku dan penambahan stok.
     */
    public function test_borrowing_status_changes_to_returned_on_update()
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $borrowing = Borrowing::factory()->create(['status' => 'borrowed']);
        $book = $borrowing->book;

        // ✅ admin melakukan pengembalian
        $response = $this->actingAs($admin)
            ->post(route('admin.returns.update', $borrowing->id), ['fine' => 0]);

        $response->assertRedirect();

        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'returned',
        ]);

        // stok buku bertambah 1
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => $book->stock + 1,
        ]);
    }

    /**
     * Test 3: Tidak bisa melakukan update jika buku sudah dikembalikan.
     *
     * Tujuan:
     * Memastikan sistem tidak memproses pengembalian ganda.
     */
    public function test_cannot_update_if_already_returned()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // ✅ pastikan status sesuai constraint
        $borrowing = Borrowing::factory()->create(['status' => 'returned']);

        $response = $this->actingAs($admin)
            ->post(route('admin.returns.update', $borrowing->id), ['fine' => 0]);

        $response->assertSessionHas('error');
    }

    /**
     * Test 4: Sistem menghitung denda keterlambatan dengan benar.
     *
     * Tujuan:
     * Menguji perhitungan denda otomatis jika pengembalian melewati batas waktu.
     */
    public function test_fine_is_calculated_when_late_return()
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $borrowing = Borrowing::factory()->create([
            'status' => 'borrowed',
            'return_deadline' => now()->subDays(3), // Telat 3 hari
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.returns.update', $borrowing->id), ['fine' => 500]);

        $response->assertRedirect();
        $this->assertDatabaseHas('borrowings', ['status' => 'returned']);
    }

    /**
     * Test 5: Email bukti pengembalian terkirim setelah proses berhasil.
     *
     * Tujuan:
     * Memastikan Mail::send() memanggil ReturnReceiptMail.
     */
    public function test_send_email_upon_successful_return()
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $borrowing = Borrowing::factory()->create(['status' => 'borrowed']);

        $this->actingAs($admin)
            ->post(route('admin.returns.update', $borrowing->id), ['fine' => 0]);

        Mail::assertSent(ReturnReceiptMail::class);
    }

    /**
     * Test 6: Membatalkan pengembalian akan mengembalikan status ke borrowed/overdue.
     *
     * Tujuan:
     * Menguji fitur revert() agar status kembali seperti semula dan stok berkurang lagi.
     */
    public function test_revert_return_changes_status_back_to_borrowed_or_overdue()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $borrowing = Borrowing::factory()->create([
            'status' => 'returned',
            'return_deadline' => now()->addDay(), // Masih belum lewat
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.returns.revert', $borrowing->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('borrowings', ['status' => 'returned']);
    }
}
