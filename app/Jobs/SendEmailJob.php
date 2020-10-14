<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\BookAdded;
use App\Mail\BookDeleted;
use App\Models\Book;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $detail;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Book $book, $recipient, $type)
    {
        $this->book = $book;
        $this->recipient = $recipient;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'deleted') {
            Mail::to($this->recipient)->send(new BookDeleted($this->book));
        } else if ($this->type == 'added') {
            Mail::to($this->recipient)->send(new BookAdded($this->book));
        }
    }
}
