<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalOrderToday extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Revenue Today (VND)',
                number_format(Order::whereDate('created_at', date('Y-m-d'))->where('status', OrderStatusEnum::COMPLETED->value)->sum('price'), 2)),
            Stat::make('Revenue Last 7 Days (VND)',
                number_format(Order::where('created_at', '>=', now()->subDays(7)->startOfDay())->where('status', OrderStatusEnum::COMPLETED->value)->sum('price'), 2)),
            Stat::make('Revenue Last 30 Days (VND)',
                number_format(Order::where('created_at', '>=', now()->subDays(30)->startOfDay())->where('status', OrderStatusEnum::COMPLETED->value)->sum('price'), 2))
        ];
    }
}
