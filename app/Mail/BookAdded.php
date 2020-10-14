<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Book;

class BookAdded extends Mailable
{
    use Queueable, SerializesModels;

    protected $book;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // To be edited as required
        return $this->from('example@example.com')
                    ->view('emails.books_added')
                    ->subject('Book Added')
                    ->with([
                        'name' => auth()->user()->name,
                        'bookTitle' => $this->book->title,
                        'bookAuthor' => $this->book->author
                    ]);
    }
}
