<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OrderChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'orderChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'OrderChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [

        ];
    }
}
