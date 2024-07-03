<?php
namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Order;

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
    protected static ?int $sort = 2;


    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $currentDate = now();
        $fourYearsAgo = $currentDate->copy()->subYears(4)->startOfYear();

        $orders = Order::whereIn('type', ['sale', 'purchase'])
            ->selectRaw("YEAR(created_at) as year, type, SUM(total_price) as total")
            ->where('created_at', '>=', $fourYearsAgo)
            ->groupBy(DB::raw('YEAR(created_at)'), 'type')
            ->orderBy('created_at')
            ->get();

        $salesData = [];
        $purchasesData = [];
        $categories = [];

        foreach ($orders as $order) {
            $year = $order->year;

            if ($order->type === 'sale') {
                if (!isset($salesData[$year])) {
                    $salesData[$year] = 0;
                }
                $salesData[$year] += round($order->total, 2);
            } else {
                if (!isset($purchasesData[$year],)) {
                    $purchasesData[$year] = 0;
                }
                $purchasesData[$year] += round($order->total, 2);
            }

            if (!in_array($year, $categories, true)) {
                $categories[] = $year;
            }
        }

        $lastFourYears = [];
        for ($i = 4; $i >= 0; $i--) {
            $lastFourYears[] = $currentDate->copy()->subYears($i)->format('Y');
        }

        foreach ($lastFourYears as $year) {
            if (!isset($salesData[$year])) {
                $salesData[$year] = 0;
            }
            if (!isset($purchasesData[$year])) {
                $purchasesData[$year] = 0;
            }
        }

        ksort($salesData);
        ksort($purchasesData);

        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Sales',
                    'data' => array_values($salesData),
                ],
                [
                    'name' => 'Purchases',
                    'data' => array_values($purchasesData),
                ],
            ],
            'xaxis' => [
                'categories' => $lastFourYears,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b', '#3b82f6'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'tooltip' => [
                'x' => [
                    'format' => 'yyyy',
                ],
            ],
        ];
    }
}
