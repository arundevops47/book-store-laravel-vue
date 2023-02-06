<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
			$this->app->singleton(Client::class, function () {
				$client = ClientBuilder::create()
						->setHosts(['localhost:9200'])
						// ->setBasicAuthentication('elastic', 'password copied during Elasticsearch start')
						// ->setCABundle('path/to/http_ca.crt')										
						->build();
				return $client;
			});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
