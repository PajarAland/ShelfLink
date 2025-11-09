<?php

namespace App\Mail;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Peminjaman Buku')
                    ->view('emails.borrow_confirmation');
    }
}
