<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class GenerateBookIndex extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'generate:bookindex';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This Command used to generate index of books';

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
					// 'type' => '_doc',
					'body' => $book->toArray(),
				];

				$client->index($params);
			} catch (\Exception $e) {
				$this->info($e->getMessage());
			}
		}

		$this->info("Books were successfully indexed");

		return Command::SUCCESS;
	}
}
