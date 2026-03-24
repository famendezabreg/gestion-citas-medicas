<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class DoctorAvailabilityCalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.doctor-availability-calendar';
    protected static ?int $sort = 3;
    protected int|string $columnSpan = 'full';

    public int $month;
    public int $year;

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year  = now()->year;
    }

    public function previousMonth(): void
    {
        $date        = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year  = $date->year;
    }

    public function nextMonth(): void
    {
        $date        = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year  = $date->year;
    }

    protected function getViewData(): array
    {
        $firstDay    = Carbon::createFromDate($this->year, $this->month, 1);
        $daysInMonth = $firstDay->daysInMonth;

        // Carbon: 0=Sunday ... 6=Saturday. Adjust to start on Monday (0=Monday ... 6=Sunday)
        $startOffset = ($firstDay->dayOfWeek === 0) ? 6 : $firstDay->dayOfWeek - 1;

        // Load all schedules grouped by day_of_week (1=Mon ... 7=Sun in Carbon isoWeekday)
        $rawSchedules = Schedule::with('doctor.user')
            ->whereHas('doctor', fn ($q) => $q->where('active', true))
            ->get();

        $schedulesByDay = [];
        foreach ($rawSchedules as $schedule) {
            $day = $schedule->day_of_week; // 1=Mon, 2=Tue ... 6=Sat, 0=Sun
            $schedulesByDay[$day][] = [
                'name'  => $schedule->doctor->user->name ?? 'Sin nombre',
                'start' => substr($schedule->start_time, 0, 5),
                'end'   => substr($schedule->end_time, 0, 5),
            ];
        }

        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        return [
            'daysInMonth'    => $daysInMonth,
            'startOffset'    => $startOffset,
            'schedulesByDay' => $schedulesByDay,
            'monthName'      => $months[$this->month] . ' ' . $this->year,
            'today'          => now()->day,
            'isCurrentMonth' => $this->month === now()->month && $this->year === now()->year,
        ];
    }
}
