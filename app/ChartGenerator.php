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
            
            if ($randomEvent > 50) {                
                //Buy side variables
                if ($randomEvent >= 85 && $randomEvent < 100) {
                    $price = $price + 5;
                    array_push($prices, $price);
                    continue;
                } elseif (($lastPrice) && ($percentChange < -0.07)) {
                    $price = $price + 3;
                    array_push($prices, $price);
                    continue;
                } elseif (($lastPrice) && ($percentChange < -0.15)) {
                    $price = $price + 5;
                    array_push($prices, $price);
                    continue;
                } else {
                    $price = $price + 1;
                }
            } else {
                // Sell side variables
                if ($randomEvent > 1 && $randomEvent <= 16) {
                    $price = $price - 5;
                    array_push($prices, $price);
                    continue;
                } elseif (($lastPrice) && ($percentChange > 0.07)) {
                    $price = $price - 3;
                    array_push($prices, $price);
                    continue;
                } elseif (($lastPrice) && ($percentChange > 0.15)) {
                    $price = $price - 5;
                    array_push($prices, $price);
                    continue;
                } else {
                    $price = $price - 1;                
                }
            }

            //Long side variables
            if (($allTimeHigh > 52) && ($price - $allTimeHigh)/$allTimeHigh < -0.5) {
                $price = $price + 10;
                array_push($prices, $price);
                continue;
            }
            if (($allTimeHigh > 52) && ($price - $allTimeHigh)/$allTimeHigh > 0.5) {
                $price = $price - 10;
                array_push($prices, $price);
                continue;
            }
            if ($price < 0) {
                $price = 0;
            }

            //Improbable Events
            switch ($randomEvent) {
                case 1:
                    $price = $price + 30;
                break;
                case 100:
                    $price = $price - 50;
                break;
            }
            

            array_push($prices, $price);
        }

        return [$prices, $limit];
    }
}
