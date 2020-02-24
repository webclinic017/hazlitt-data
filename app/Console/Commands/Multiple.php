<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Commodity;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;


class Multiple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:multiple';

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
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);
        $client = new Client();
        $commodities = Commodity::all();

        $urls = [];
        foreach ($commodities as $commodity) {
            array_push($urls, 'https://news.google.com/search?q=' . strtolower(str_replace(' ', '+', $commodity->name)) . '+' . 'supply');
            array_push($urls, 'https://news.google.com/search?q=' . strtolower(str_replace(' ', '+', $commodity->name)) . '+' . 'prices');
            array_push($urls, 'https://news.google.com/search?q=' . strtolower(str_replace(' ', '+', $commodity->name)) . '+' . 'demand');
        }                
        foreach ($urls as $url) {         
            $promise = $client->requestAsync('GET', 'http://httpbin.org/get');
            $promise->then(function ($response) use ($url) {
                $this->info($url . ' '. $response->getStatusCode());
            })->wait(0);   
            // $promise = $client->requestAsync('GET', $url);
            // $this->info($url); 

            // $promise->then(
            //     function (ResponseInterface $res) {
            //         $this->info($res->getStatusCode() . "\n");
            //     },
            //     function (RequestException $e) {
            //         $this->info($e->getMessage() . "\n");
            //         $this->info($e->getRequest()->getMethod());
            //     }
            // );           
        }
        
        // dd($body);
        // // Guzzle returns an array of Responses.
        // $guzzleResponses = $client->send(array(
        //     $client->get('https://news.google.com/search?q=supply'),
        //     $client->get('https://news.google.com/search?q=demand'),
        //     $client->get('https://news.google.com/search?q=prices')
        // ));

        // // Iterate through all of the guzzle responses.
        // foreach ($guzzleResponses as $guzzleResponse) {
        //     $goutteObject = new Symfony\Component\BrowserKit\Response(
        //         $guzzleResponse->getBody(true),
        //         $guzzleResponse->getStatusCode(),
        //         $guzzleResponse->getHeaders()
        //     );

        // Do things with $goutteObject as you normally would.
        
        $end = microtime(true);
        $time = number_format($end - $start);
        $this->info("\n" . 'Done: ' . $time . ' seconds');
    }
}
