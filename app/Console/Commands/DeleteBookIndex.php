<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Elastic\Elasticsearch\Client;

class DeleteBookIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:bookindex';
		protected $bookId;
		
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command used to delete index of books';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $client)
    {
			$books = Book::select('id', 'title', 'author', 'genre', 'description', 'isbn', 'image', 'published', 'publisher')->get();
	
			foreach ($books as $book) {
				try {
					$params = [
						'index' => env('ELASTICSEARCH_INDEX'),
						'id' => $book->id,
					];
	
					$client->delete($params);
				} catch (\Exception $e) {
					$this->info($e->getMessage());
				}
			}
	
			$this->info("Books index were successfully deleted");			

      return Command::SUCCESS;
    }
}
