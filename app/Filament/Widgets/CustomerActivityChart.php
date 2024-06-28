<?php
namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Order;
use App\Models\Event;
use Carbon\Carbon;

class CustomerActivityChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'customerActivityChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Customer Activity';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $currentDate = Carbon::now();
        $sixMonthsAgo = $currentDate->copy()->subMonths(6);

        $dataSeries = Order::where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $seriesData = $dataSeries->pluck('count')->toArray();
        $categories = $dataSeries->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->toArray();

        $annotations = $this->getEventAnnotations($sixMonthsAgo);

        return [
            'chart' => [
                'height' => 350,
                'type' => 'line',
                'id' => 'customerActivityChart'
            ],
            'annotations' => $annotations,
            'dataLabels' => [
                'enabled' => false
            ],
            'stroke' => [
                'curve' => 'smooth'
            ],
            'grid' => [
                'padding' => [
                    'right' => 30,
                    'left' => 20
                ]
            ],
            'title' => [
                'text' => 'Customer Order Activity (Last 6 Months)',
                'align' => 'left'
            ],
            'labels' => $categories,
            'xaxis' => [
                'type' => 'datetime',
            ],
            'series' => [
                [
                    'name' => 'Orders',
                    'data' => $seriesData
                ]
            ],
            'colors' => [
                '#FF5733', '#FFC300', '#DAF7A6', '#33FF57', '#3357FF',
                '#8A33FF', '#EE33FF', '#FF33A6', '#FF3357', '#FF5733'
            ],
        ];
    }

    private function getEventAnnotations($fromDate)
    {
        $events = Event::where('start_time', '>=', $fromDate)->get();
        $annotations = [
            'xaxis' => [],
            'yaxis' => [],
            'points' => []
        ];

        $colors = [
            '#FF5733', '#FFC300', '#DAF7A6', '#33FF57', '#3357FF',
            '#8A33FF', '#EE33FF', '#FF33A6', '#FF3357', '#FF5733'
        ];
        $colorIndex = 0;

        foreach ($events as $event) {
            $color = $colors[$colorIndex % count($colors)];
            $annotations['xaxis'][] = [
                'x' => Carbon::parse($event->start_time)->timestamp * 1000,
                'label' => [
                    'text' => $event->title,
                    'style' => [
                        'color' => '#fff',
                        'background' => $color,
                    ]
                ]
            ];
            $colorIndex++;
        }

        return $annotations;
    }
}
