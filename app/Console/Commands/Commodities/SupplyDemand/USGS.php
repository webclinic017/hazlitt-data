<?php

namespace App\Console\Commands\Commodities\SupplyDemand;

use App\Commodity;
use Illuminate\Support\Carbon;
// use Unirest\Request;
// use Unirest\Request\Header;
// use Unirest\Request\Body;
use Illuminate\Support\Arr;
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
                
                $url = $archivedUrl;
                if ((int) $year > 2016) {
                    $url = $recentUrl;
                }

                foreach ($slugs as $slug) {
                    foreach ($extensions as $ext) {
                        $this->comment($url . $slug . $ext);

                        $curl = curl_init();
                        $err = curl_error($curl);
                        curl_setopt($curl, CURLOPT_URL, $url . $slug. $ext);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
                        $file_data = curl_exec($curl);
                        curl_close($curl);
                        if ($err) {
                            continue;
                        }

                        $file_path = config('app.downloads_folder') . $year . $commodity->slug . $ext;
                        $file = fopen($file_path, 'w+');
                        fputs($file, $file_data);
                        fclose($file);
                        
                        sleep(2);
                    }
                }
            }
        }
        
        $end = microtime(true);
        $time = number_format(($end - $start) / 60);
        $this->info("\n" . 'Done: ' . $time . ' minutes');
    }
}
