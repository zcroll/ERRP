<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DeliveredOrderChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?int $sort = 1;

    protected static ?string $chartId = 'deliveredOrderChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Order Status';

    /**
     * Widget content height
     */
    protected static ?int $contentHeight = 270;

    protected function getFooter(): string
    {
        $statuses = Order::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();

        return view('order-status', ['statuses' => $statuses]);
    }

    protected function getOptions(): array
    {
        $statuses = Order::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();

        $total = array_sum($statuses);

        $percentages = array_map(function ($count) use ($total) {
            return $total != 0 ? round($count / $total * 100) : 0;
        }, $statuses);

        $labels = array_keys($statuses);
        $series = array_values($percentages);

        $highlightIndex = array_search('delivered', $labels);
        $highlightValue = $highlightIndex !== false ? $series[$highlightIndex] : 0;

        return [
            'chart' => [
                'type' => 'radialBar',
                'height' => 280,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => $series,
            'plotOptions' => [
                'radialBar' => [
                    'startAngle' => -140,
                    'endAngle' => 130,
                    'hollow' => [
                        'size' => '60%',
                        'background' => 'transparent',
                    ],
                    'track' => [
                        'background' => 'transparent',
                        'strokeWidth' => '100%',
                    ],
                    'dataLabels' => [
                        'show' => true,
                        'name' => [
                            'show' => true,
                            'offsetY' => -10,
                            'fontWeight' => 600,
                            'fontFamily' => 'inherit',
                        ],
                        'value' => [
                            'show' => true,
                            'fontWeight' => 600,
                            'fontSize' => '24px',
                            'fontFamily' => 'inherit',
                        ],
                    ],
                ],
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'dark',
                    'type' => 'horizontal',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#f59e0b'],
                    'inverseColors' => true,
                    'opacityFrom' => 1,
                    'opacityTo' => 0.6,
                    'stops' => [30, 70, 100],
                ],
            ],
            'stroke' => [
                'dashArray' => 10,
                'show' => true,
            ],
            'annotations' => [
                'points' => [
                    [
                        'x' => $highlightValue,
                        'y' => 0,
                        'marker' => [
                            'size' => 7,
                            'fillColor' => '#16a34a',
                            'strokeColor' => '#ffffff',
                        ],
                        'label' => [
                            'borderColor' => '#16a34a',
                            'offsetY' => 0,
                            'style' => [
                                'color' => '#fff',
                                'background' => '#16a34a',
                            ],
                            'text' => 'Delivered',
                        ],
                    ],
                ],
            ],
            'labels' => $labels,
            'colors' => ['#16a34a', '#ef4444', '#3b82f6', '#fbbf24', '#a855f7'] // Adjust/add more colors if necessary
        ];
    }
}
