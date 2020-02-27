<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
// use Goutte\Client;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Arr;
use App\Article;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class AsyncScraper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //Collect sessions from users in the checkout process for abandoned cart emails. Session is deleted upon checkout.

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $_item;
    protected $_topics;
    protected $_type;

    public function __construct($item, $topics, $type)
    {
        $this->_item = $item;
        $this->_topics = $topics;
        $this->_type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();        
        $item = $this->_item;
        $topics = $this->_topics;
        $type = $this->_type;
        // // $output = new OutputFormatterStyle();
        

        foreach ($topics as $topic) {
            $query = strtolower(str_replace(' ', '+', $item->name)) . '+' . $topic;            
            // $output->writeln("<comment>\n" . 'https://news.google.com/search?q=' . $query . "<comment>");

            $promise = $client->requestAsync('GET', 'https://news.google.com/search?q=' . $query);
            $promise->then(function ($response) use ($item, $topic, $type) {
                $body = $response->getBody()->getContents();

                $crawler = new Crawler($body);
                $crawler->filter('article')->each(function ($node, $ranking) use ($item, $topic, $type) {
                    if (!isset($node)) {
                        // $output->writeln('<warn>No articles</warn>');
                        return;
                    }
                    if (
                        $node->filter('article > h3 > a')->count() == 0 ||
                        $node->filter('a.wEwyrc')->count() == 0 ||
                        $node->filter('time')->count() == 0 ||
                        $node->filter('article a')->count() == 0
                    ) {
                        return;
                    }
                    
                    # Manually constructing article link from jslog attribute.
                    $jslog = $node->filter('article')->attr('jslog');
                    $jslog_split = explode(";", $jslog);
                    
                    $url_stripped = explode(":", $jslog_split[1], 2);
                    $article_url = $url_stripped[1];

                    //Remove duplicates
                    $duplicate = Article::where('item_id', '=', $item->id)
                        ->where('item_type', '=', $type)
                        ->where('url', '=', $article_url)
                        ->count();
                    if ($duplicate != 0) {                        
                        // $output->writeln('<warn>Duplicate article</warn>');
                        return;
                    }

                    # Removing Google's random Z from timestamp
                    $timestamp = $node->filter('time')->attr('datetime');
                    $date_split = explode('Z', $timestamp);
                    $published = $date_split[0];
                

                    $article = new Article();
                    $article->headline      = $node->filter('h3 > a')->text();
                    $article->url           = $article_url;
                    $article->source        = $node->filter('a.wEwyrc')->text();
                    $article->topic         = $topic;
                    $article->ranking       = $ranking;
                    $article->published     = $published;

                    $article->save();
                    $item->articles()
                        ->save($article);
                        
                    // $output->writeln('<info>'. $item->name . ' - ' . $article->source . ' saving article to database' . '</info>');
                });
            })->wait();
        }
    }
}
