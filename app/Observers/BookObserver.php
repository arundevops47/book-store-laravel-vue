<?php

namespace App\Observers;

use Elastic\Elasticsearch\Client;

use App\Jobs\IndexBookElasticsearchJob;
use App\Jobs\RemoveBookElasticsearchJob;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BookObserver
{

    /**
     * Handle the Book "created" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
			dispatch(new IndexBookElasticsearchJob($book));
    }

    /**
     * Handle the Book "updated" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
        //
    }

    /**
     * Handle the Book "deleted" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
      dispatch(new RemoveBookElasticsearchJob($book->id));
    }

    /**
     * Handle the Book "restored" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
			dispatch(new IndexBookElasticsearchJob($book));
    }

    /**
     * Handle the Book "force deleted" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {
			dispatch(new RemoveBookElasticsearchJob($book->id));
    }
}
