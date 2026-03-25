<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class DoctorAvailabilityCalendarWidget extends Widget
{
    protected string $view = 'filament.widgets.doctor-availability-calendar';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public int $month;

    public int $year;

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public function previousMonth(): void
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function nextMonth(): void
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    protected function getViewData(): array
    {
        $firstDay = Carbon::createFromDate($this->year, $this->month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startOffset = ($firstDay->dayOfWeek === 0) ? 6 : $firstDay->dayOfWeek - 1;

        $rawSchedules = Schedule::with('doctor.user')
            ->whereHas('doctor', fn ($query) => $query->where('active', true))
            ->get()
            ->sortBy([
                ['day_of_week', 'asc'],
                ['start_time', 'asc'],
            ]);

        $schedulesByDay = [];

        foreach ($rawSchedules as $schedule) {
            $day = $schedule->day_of_week;
            $schedulesByDay[$day][] = [
                'name' => $schedule->doctor->user->name ?? 'Sin nombre',
                'start' => substr($schedule->start_time, 0, 5),
                'end' => substr($schedule->end_time, 0, 5),
            ];
        }

        $months = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return [
            'daysInMonth' => $daysInMonth,
            'startOffset' => $startOffset,
            'schedulesByDay' => $schedulesByDay,
            'monthName' => $months[$this->month] . ' ' . $this->year,
            'today' => now()->day,
            'isCurrentMonth' => $this->month === now()->month && $this->year === now()->year,
            'activeDoctorsCount' => $rawSchedules->pluck('doctor_id')->unique()->count(),
            'scheduleBlocksCount' => $rawSchedules->count(),
            'coveredDaysCount' => collect($schedulesByDay)->filter(fn ($items) => filled($items))->count(),
        ];
    }
}
