<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Elastic\Elasticsearch\Client;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class IndexBookElasticsearchJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $book;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Book $book)
	{
			$this->book = $book;
	}

	/**
	 * Execute the job.
	 * @param Client $client
	 *
	 * @return void
	 */
	public function handle(Client $client)
	{

		try {
			Log::debug('Book id: '.$this->book->id.' index creation started');

			$params = [
				'index' => env('ELASTICSEARCH_INDEX'),
				'id' => $this->book->id,
				// 'type' => '_doc',
				'body' => $this->book->toArray(),
			];
	
			$client->index($params);
	
			Log::debug('Book index creation done');
		} catch (\Exception $e) {
			throw $e;
		}

	}
}
