<?php

namespace App\Mail;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $borrow, $lateDays, $lateFine, $damageFine, $totalFine;

    public function __construct(Borrowing $borrow, $lateDays, $lateFine, $damageFine, $totalFine)
    {
        $this->borrow = $borrow;
        $this->lateDays = $lateDays;
        $this->lateFine = $lateFine;
        $this->damageFine = $damageFine;
        $this->totalFine = $totalFine;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pengembalian Buku - Perpustakaan Ceria')
                    ->view('emails.return_receipt');
    }
}
