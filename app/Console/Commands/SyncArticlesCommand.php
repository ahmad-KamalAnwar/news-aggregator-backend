<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use http\Exception;
use Illuminate\Console\Command;

class SyncArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $nyTimesUrl = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key=4XLPVJlK6zU1vQDLet5OBMvotlBhAYKe';
        $result = $this->callApiEndpoint($nyTimesUrl, 'GET');
        dd($result);

        return 0;

    }

    private function callApiEndpoint($url, $method, $options = [])
    {
        try {
//            $options['headers']['Authorization'] = "Bearer $this->token";

            $client = new Client();

            $response = $client->request($method, $url, $options);

            return json_decode($response->getBody());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
