<?php

namespace App\Console\Commands\Indicators;

use Illuminate\Console\Command;
use App\Country;
use App\Commodity;
use Illuminate\Support\Carbon;
use Goutte\Client;

class Countries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:indicators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape country indicators';

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
        $countries = Country::all();
        $client = new Client();

        foreach ($countries as $country) {

            $pages = collect([
                'inflation' => 'inflation-cpi',
                'corporate-tax' => 'corporate-tax-rate',
                'interest-rate' => 'interest-rate',
                'unemployment' => 'unemployment-rate',
                'income-tax' => 'personal-income-tax-rate',
                'gdp' => 'gdp-per-capita',
                'gov-debt' => 'government-debt-to-gdp',
                'banks-balance' => 'banks-balance-sheet',
                'central-bank-balance' => 'central-bank-balance-sheet',
                'gov-budget' => 'government-budget-value'
            ])

            try {
                $this->comment("\n" . 'https://tradingeconomics.com' . $country->slug.  '/inflation-cpi');
                $inflation_html = $client->request('GET', 'https://tradingeconomics.com' . $country->slug.  '/inflation-cpi');                    

                $country_id = $country->id;
                $commodity_name = $country->name;
                $category = $query;

            }

        }
    }
}


// inflation_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/inflation-cpi"))
// puts "got #{country.name} inflation data"
// sleep(num_sec)
// corporate_tax_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/corporate-tax-rate"))
// puts "got #{country.name} corporate tax rate data"
// sleep(num_sec)
// interest_rate_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/interest-rate"))
// puts "got #{country.name} interest rate data"
// sleep(num_sec)
// unemployment_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/unemployment-rate"))
// puts "got #{country.name} unemployment data"
// sleep(num_sec)
// income_tax_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/personal-income-tax-rate"))
// puts "got #{country.name} income tax data"
// sleep(num_sec)
// gdp_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/gdp-per-capita"))
// puts "got #{country.name} gdp data"
// sleep(num_sec)
// gov_debt_to_gdp_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/government-debt-to-gdp"))
// puts "got #{country.name} gov debt to gdp data"
// sleep(num_sec)
// bank_balance_sheet_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/banks-balance-sheet"))
// puts "got #{country.name} banks balance sheet data"
// sleep(num_sec)
// central_bank_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/central-bank-balance-sheet"))
// puts "got #{country.name} central bank data"
// sleep(num_sec)
// budget_page = Nokogiri::HTML(HTTParty.get("https://tradingeconomics.com/#{country.name}/government-budget-value"))