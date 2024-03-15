<?php

namespace App\Charts;


use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyWoChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        // return $this->chart->pieChart()
        //     ->setTitle('Wo Installation FTTH Januari 2024')
        //     ->setSubtitle('Season 2021.')
        //     ->setDataSet([40, 50, 30])
        //     ->setLabels(['Player 7', 'Player 10', 'Player 9'])
        //     ->setMarkers(['#FF5722', '#E040FB'], 7, 10);

            return $this->chart->pieChart()
    ->setTitle('Sales during 2021.')
    ->setSubtitle('Physical sales vs Digital sales.')
    ->setDataSet([40, 93, 35, 42, 18, 82])
    ->setDataSet([70, 29, 77, 28, 55, 45])
    ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June'])
    ->setGrid(false, '#3F51B5', 0.1)
    // ->setColors(['#FFC107', '#303F9F'])
    ->setMarkers(['#FF5722', '#E040FB'], 7, 10);
    }
}
