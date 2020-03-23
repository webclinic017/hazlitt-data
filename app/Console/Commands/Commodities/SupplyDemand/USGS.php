<?php

namespace App\Console\Commands\Commodities\SupplyDemand;

use App\Commodity;
use Illuminate\Support\Carbon;
use Unirest\Request;
use Unirest\Request\Header;
use Unirest\Request\Body;
use Illuminate\Support\Arr;
use SimpleXMLElement;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Console\Command;

class USGS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commodity:usgs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download metals supply and demand information from USGS';

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
        //https://prd-wret.s3-us-west-2.amazonaws.com/assets/palladium/production/atoms/files/myb1-2017-gold-adv.xlsx
        // https://s3-us-west-2.amazonaws.com/prd-wret/assets/palladium/production/mineral-pubs/aluminum/myb1-2015-alumi.xls


        $start = microtime(true);

        $commodities = Commodity::where('sector', '=', 'Metals')
            ->orWhere('sector', '=', 'Industrial')
            ->get();

        $recentUrl = config('services.commodity.usgs.recent');
        $years = ['2015', '2016', '2017', '2018', '2019'];
        $extensions = ['.xlsx', '.xls'];

        foreach ($commodities as $commodity) {
            //removing special characters
            $cmdty = substr(preg_replace('/[^A-Za-z0-9\-]/', '', $commodity->slug), 0, 5);
            $archivedUrl = config('services.commodity.usgs.archived') . $commodity->slug . '/';

            foreach ($years as $year) {
                $slugBase = 'myb1-' . $year . '-' . $cmdty;
                $slugAdv = 'myb1-' . $year . '-' . $cmdty . '-adv';
                $slugs = [$slugBase, $slugAdv];
                
                $uri = $archivedUrl;
                if ((int) $year > 2016) {
                    $uri = $recentUrl;
                }

                foreach ($slugs as $slug) {
                    foreach ($extensions as $ext) {
                        $url = $uri . $slug . $ext;
                        $file_name = $commodity->slug . $year . $ext;
                        $storage = '/Users/alexyounger/Sites/hazlitt-data/storage/imports/commodity/USGS/';
                        $this->comment($url);

                        if (file_exists($storage . $file_name)) {
                            continue;
                        }

                        $response = Request::get($url);
                        if ($response->code != 200) {
                            continue;
                        }

                        
                        if ($file_name == 'myb1-2017-cadmi.xls') {
                            continue;
                        }                  

                        if (file_put_contents($storage . $file_name, file_get_contents($url))) {
                            $this->info("File downloaded successfully - " . $commodity->slug . $year . $ext);
                        } else {
                            $this->error("File downloading failed.");
                        }
                    }
                }
            }
        }
        
        $end = microtime(true);
        $time = number_format(($end - $start) / 60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}
