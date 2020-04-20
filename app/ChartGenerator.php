<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ChartGenerator extends Model
{
    public function fakeData() {
        $startPrice = rand(1, 100);  
        $limit = 5000;

        $prices = [];
        foreach(range(1, $limit) as $i => $loop) {
            if ($loop == 1) {
                $price = $startPrice;
            }

            $randomEvent = rand(1, 100);
            $allTimeHigh = count($prices) > 1 ? max($prices) : 0;        
            $lastPrice = count($prices) > 1 && $i < 1 ? $prices[$loop - 1] : null;                  
            
            if ($randomEvent > 50) {
                //Buy side variables
                if ($randomEvent >= 85 && $randomEvent < 100) {
                    $price = $price + 5;
                } else if ($randomEvent == 100) { 
                    $price = $price + 30;
                } else if (($lastPrice) && (($price - $lastPrice)/$lastPrice > 0.1)) {
                    $price = $price + 3;                    
                } else if (($lastPrice) && (($price - $lastPrice)/$lastPrice > 0.3)) {
                    $price = $price - 5;
                    dd($price);
                } else {
                    $price = $price + 1;
                }
            } else {
                // Sell side variables
                if ($randomEvent > 1 && $randomEvent <= 16) {
                    $price = $price - 5;
                } else if ($randomEvent == 1) { 
                    $price = $price - 30;
                } else if (($lastPrice) && (($price - $lastPrice)/$lastPrice < -0.1)) {
                    $price = $price - 3;
                } else if (($lastPrice) && (($price - $lastPrice)/$lastPrice < -0.3)) {
                    $price = $price + 5;
                } else {
                    $price = $price - 1;
                }
            }


            array_push($prices, $price);
        }

        return [$prices, $limit];
    }
}
