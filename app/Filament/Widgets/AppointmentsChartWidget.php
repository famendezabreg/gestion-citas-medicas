<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class AppointmentsChartWidget extends ChartWidget
{
    protected ?string $heading = 'Citas por día — últimos 7 días';
    protected ?string $description = 'Total de citas activas (excluye canceladas)';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '220px';

    protected function getData(): array
    {
        $days   = collect();
        $counts = collect();
        $colors = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date  = Carbon::today()->subDays($i);
            $count = Appointment::whereDate('scheduled_at', $date)
                ->whereNotIn('status', ['cancelled'])
                ->count();

            $days->push($date->locale('es')->translatedFormat('D d/m'));
            $counts->push($count);

            // Día actual resaltado en azul, resto en índigo suave
            $colors->push(
                $date->isToday()
                    ? 'rgba(59, 130, 246, 0.9)'
                    : 'rgba(99, 102, 241, 0.5)'
            );
        }

        return [
            'datasets' => [
                [
                    'label'                     => 'Citas activas',
                    'data'                      => $counts->toArray(),
                    'backgroundColor'           => $colors->toArray(),
                    'borderColor'               => $colors->map(fn ($c) =>
                        str_replace('0.5', '1', str_replace('0.9', '1', $c))
                    )->toArray(),
                    'borderWidth'               => 1.5,
                    'borderRadius'              => 6,
                    'borderSkipped'             => false,
                ],
            ],
            'labels' => $days->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => [
                        'stepSize'  => 1,
                        'precision' => 0,
                    ],
                    'grid' => [
                        'color' => 'rgba(148, 163, 184, 0.1)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}