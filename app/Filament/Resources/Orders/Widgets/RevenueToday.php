<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueToday extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '5s';
    protected function getStats(): array
    {
        $totalRevenue = Order::whereDate('created_at', today())
            ->where('status', OrderStatusEnum::COMPLETED->value)
            ->sum('price');

        return [
            Stat::make('Revenue Today (VND)',
                number_format($totalRevenue)),
        ];
    }
}
