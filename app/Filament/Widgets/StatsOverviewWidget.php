<?php
namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use App\Models\Order;
use App\Models\EarningsLosses;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            now()->subDays(30);

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $previousStartDate = (clone $startDate)->subDays($startDate->diffInDays($endDate));
        $previousEndDate = (clone $endDate)->subDays($startDate->diffInDays($endDate));

        // Calculate for current period
        $currentPeriodStats = $this->calculateStats($startDate, $endDate);
        // Calculate for previous period
        $previousPeriodStats = $this->calculateStats($previousStartDate, $previousEndDate);

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2) . 'k';
            }

            return Number::format($number / 1000000, 2) . 'm';
        };

        $calculateDifference = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }

            return (($current - $previous) / $previous) * 100;
        };

        $newCustomersDifference = $calculateDifference($currentPeriodStats['newCustomers'], $previousPeriodStats['newCustomers']);
        $newOrdersDifference = $calculateDifference($currentPeriodStats['newOrders'], $previousPeriodStats['newOrders']);
        $earningsDifference = $calculateDifference($currentPeriodStats['earnings'], $previousPeriodStats['earnings']);
        $lossesDifference = $calculateDifference($currentPeriodStats['losses'], $previousPeriodStats['losses']);
        $purchasesDifference = $calculateDifference($currentPeriodStats['purchases'], $previousPeriodStats['purchases']);
        $costDifference = $calculateDifference($currentPeriodStats['cost'], $previousPeriodStats['cost']);

        return [

            Stat::make('New customers', $formatNumber($currentPeriodStats['newCustomers']))
                ->description(number_format(abs($newCustomersDifference), 2) . '% ' . ($newCustomersDifference >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($newCustomersDifference >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color($newCustomersDifference >= 0 ? 'success' : 'danger'),
            Stat::make('New orders', $formatNumber($currentPeriodStats['newOrders']))
                ->description(number_format(abs($newOrdersDifference), 2) . '% ' . ($newOrdersDifference >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($newOrdersDifference >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color($newOrdersDifference >= 0 ? 'success' : 'danger'),
            Stat::make('Total Earnings', '$' . $formatNumber($currentPeriodStats['earnings']))
                ->description(number_format(abs($earningsDifference), ) . '% ' . ($earningsDifference >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($earningsDifference >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([10, 8, 12, 9, 14, 6, 15])
                ->color($earningsDifference >= 0 ? 'primary' : 'warning'),
            Stat::make('Total Losses', '$' . $formatNumber($currentPeriodStats['losses']))
                ->description(number_format(abs($lossesDifference), 2) . '% ' . ($lossesDifference >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($lossesDifference >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([5, 7, 3, 6, 8, 4, 9])
                ->color($lossesDifference >= 0 ? 'danger' : 'primary'),
            Stat::make('Products Purchased', $formatNumber($currentPeriodStats['purchases']))
                ->description(number_format(abs($purchasesDifference), 2) . '% ' . ($purchasesDifference >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($purchasesDifference >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([10, 11, 13, 15, 12, 14, 16])
                ->color($purchasesDifference >= 0 ? 'success' : 'danger'),
            Stat::make('Total Purchase Cost', '$' . $formatNumber($currentPeriodStats['cost']))
                ->description(number_format(abs($costDifference), 2) . '% ' . ($costDifference >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($costDifference >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([8, 9, 10, 11, 13, 12, 14])
                ->color($costDifference >= 0 ? 'primary' : 'warning'),
        ];
    }

    private function calculateStats($startDate, $endDate)
    {
        // Revenue (only 'sale' orders)
        $orders = Order::where('type', 'purchase')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalRevenue = $orders->reduce(function ($carry, $order) {
            return $carry + $order->total_amount;
        }, 0);

        $totalNewCustomers = $orders->unique('customer_id')->count();
        $totalNewOrders = $orders->count();

        // Calculating earnings and losses
        $earningsLosses = EarningsLosses::whereIn('order_id', $orders->pluck('id'))->get();
        $totalEarnings = $earningsLosses->sum('earnings');
        $totalLosses = $earningsLosses->sum('losses');

        // Purchase (only 'purchase' orders)
        $purchaseOrders = Order::where('type', 'purchase')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $purchaseOrderIds = Order::where('type', 'purchase')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->pluck('id');

        $totalPurchases = OrderItem::whereIn('order_id', $purchaseOrderIds)->sum('quantity');
        $totalPurchaseCost = OrderItem::whereIn('order_id', $purchaseOrderIds)->sum('unit_price'); // Assuming 'total_amount' represents the cost

        return [
            'newCustomers' => $totalNewCustomers,
            'newOrders' => $totalNewOrders,
            'earnings' => $totalEarnings,
            'losses' => $totalLosses,
            'purchases' => $totalPurchases,
            'cost' => $totalPurchaseCost,
        ];
    }
}
