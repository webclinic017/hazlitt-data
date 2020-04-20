<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ChartGenerator;
use App\Charts\GenerateFakeChart;

class ResearchController extends Controller
{
    public function chart_generator(Request $request)
    {
        $fakeChart = new ChartGenerator;
        $fakeSet = $fakeChart->fakeData();
        $data = collect($fakeSet)->first();
        $range = collect($fakeSet)->last();

        $chart = new GenerateFakeChart;
        $chart->labels(range(1, $range));
        $chart->dataset('Fake Prices', 'line', $data)
            ->color('#f2d024')
            ->fill(true, '#ffe873')
            ->lineTension(0.4)
            ->options([
                'pointRadius' => 0,
            ]);
            

        return view('research.chart_generator', compact('chart'));            
    }
}
