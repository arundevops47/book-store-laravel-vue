<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elastic\Elasticsearch\Client;

class ElasticsearchPing extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'elasticsearch:ping';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Ping Elasticsearch';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle(Client $client)
	{

		if ($client->ping()) {
			$this->info('Yes, Elasticsearch is working');
			return;
		}

		$this->error('Could not connect to Elasticsearch');
	}
}
