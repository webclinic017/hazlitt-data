<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ChartGenerator extends Model
{
    public function fakeData()
    {
        $ipoPrice = rand(1, 100);
        $limit = 5000;

        $prices = [];
        foreach (range(1, $limit) as $i => $loop) {
            if ($loop == 1) {
                $price = $ipoPrice;
            }

            $randomEvent = rand(1, 100);
            $allTimeHigh = count($prices) > 1 ? max($prices) : 0;
            $lastPrice = (count($prices) > 1 && $i > 1) ? $prices[$i - 1] : null;
            $percentChange = ($prices != 0 && $lastPrice != 0) ? ($price - $lastPrice) / $lastPrice : 0;
            
            //Improbable Events
            if ($randomEvent == 1) {
                $price = $price - 10;
                array_push($prices, $price);
                continue;
            }
            if ($randomEvent == 100) {
                $price = $price + 8;
                array_push($prices, $price);
                continue;
            }
            
            if ($randomEvent > 50) {                
                //Buy side variables
                if ($randomEvent >= 85 && $randomEvent < 100) {
                    $price = $price + 5;
                } else {
                    $price = $price + 1;
                }
            } else {
                // Sell side variables
                if ($randomEvent > 1 && $randomEvent <= 16) {
                    $price = $price - 5;
                } else {
                    $price = $price - 1;                
                }
            }

            if ($price < 5) {
                $price = 5;
            }
            

            array_push($prices, $price);
        }

        return [$prices, $limit];
    }
}
