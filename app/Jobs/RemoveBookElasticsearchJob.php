<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\Log;
// use Elastic\Elasticsearch\Common\Exceptions\Missing404Exception;

class RemoveBookElasticsearchJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $bookId;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($bookId)
	{
		$this->bookId = $bookId;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(Client $client)
	{
		Log::debug('Book id: '.$this->bookId.' index deletion started');

		try {
			$params = [
				'index' => env('ELASTICSEARCH_INDEX'),
				'id' => $this->bookId,
			];

			$client->delete($params);
			
			Log::debug('Book index deletion done');
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
