<?php

namespace App\Console\Commands\Indicators;

use Illuminate\Console\Command;
use App\Country;
use App\Commodity;
use Illuminate\Support\Carbon;
use Goutte\Client;

class CountryIndicators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indicators:countries';

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
                'corporate_tax' => 'corporate-tax-rate',
                'interest_rate' => 'interest-rate',
                'unemployment_rate' => 'unemployment-rate',
                'labor_force' => 'labor-force-participation-rate',
                'income_tax' => 'personal-income-tax-rate',
                'gdp' => 'gdp-per-capita',
                'gov_debt_to_gdp' => 'government-debt-to-gdp',
                'central_bank_balance_sheet' => 'central-bank-balance-sheet',
                'budget' => 'government-budget-value'
            ]);

            $pages->each(function ($slug, $indicator) use ($country, $client) {

                try {

                    $this->comment("\n" . 'https://tradingeconomics.com/' . $country->slug .  '/' . $slug);
                    $crawler = $client->request('GET', 'https://tradingeconomics.com/' . $country->slug .  '/' . $slug);

                    $crawler->filter('body')->each(function ($node) use ($country, $indicator) {
                        if (!isset($node)) {
                            $this->alert($country->name . ' ' . $indicator . ' indicator missing.');
                            return;
                        }

                        if (
                            $node->filter('#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)')->count() == 0
                        ) {
                            $this->alert($country->name . ' ' . $indicator . ' indicator missing.');
                            return;
                        }

                        $country = Country::query()
                            ->whereName($country->name);

                        $country->update([
                            $indicator => $node->filter('#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)')->text()
                        ]);
                    });
                    $this->info('Saving ' . $country->name . ' ' . $indicator);
                } catch (\Exception $e) {
                    $this->error($e);
                    report($e);
                }
            });
        }
        $end = microtime(true);
        $time = number_format(($end - $start), 2);
        $this->info("\n" . 'Done: ' . $time . ' seconds');
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

// Country.where(name: "#{country.name}").update(
//     inflation: inflation_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     corporate_tax: corporate_tax_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     interest_rate: interest_rate_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     unemployment: unemployment_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     income_tax: income_tax_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     gdp: gdp_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     gov_debt_to_gdp: gov_debt_to_gdp_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     bank_balance_sheet: bank_balance_sheet_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     central_bank: central_bank_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip,
//     budget: budget_page.css("#ctl00_ContentPlaceHolder1_ctl03_PanelDefinition td:nth-child(2)").text.strip
//     )
//     puts "Pages Scraped, Indicators Saved"
// end
