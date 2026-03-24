<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $todayAppointments = Appointment::whereDate('scheduled_at', today())
            ->whereNotIn('status', ['cancelled'])
            ->count();

        $pendingAppointments = Appointment::where('status', 'pending')->count();

        return [
            Stat::make('Total de Pacientes', Patient::count())
                ->description('Registrados en el sistema')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Citas Hoy', $todayAppointments)
                ->description('Citas activas para hoy')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Citas Pendientes', $pendingAppointments)
                ->description('Sin confirmar aún')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}