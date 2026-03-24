<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class AppointmentsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Citas por día (últimos 7 días)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days   = collect();
        $counts = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days->push($date->format('D d/m'));
            $counts->push(
                Appointment::whereDate('scheduled_at', $date)
                    ->whereNotIn('status', ['cancelled'])
                    ->count()
            );
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Citas',
                    'data'            => $counts->toArray(),
                    'backgroundColor' => '#6366f1',
                    'borderColor'     => '#4f46e5',
                ],
            ],
            'labels' => $days->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}