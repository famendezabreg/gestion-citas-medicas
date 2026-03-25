<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class DoctorAvailabilityCalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.doctor-availability-calendar';
    protected static ?int $sort   = 3;
    protected int|string $columnSpan = 'full';

    public int $month;
    public int $year;
    public ?int $selectedDay = null;

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year  = now()->year;
    }

    public function previousMonth(): void
    {
        $date              = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month       = $date->month;
        $this->year        = $date->year;
        $this->selectedDay = null;
    }

    public function nextMonth(): void
    {
        $date              = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month       = $date->month;
        $this->year        = $date->year;
        $this->selectedDay = null;
    }

    public function selectDay(int $day): void
    {
        $this->selectedDay = ($this->selectedDay === $day) ? null : $day;
    }

    protected function getViewData(): array
    {
        return [
            'calendarData'    => $this->buildCalendarData(),
            'selectedDayData' => $this->buildSelectedDayData(),
        ];
    }

    private function buildCalendarData(): array
    {
        $firstDay    = Carbon::createFromDate($this->year, $this->month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startOffset = ($firstDay->dayOfWeek === 0) ? 6 : $firstDay->dayOfWeek - 1;

        // Schedules grouped by day_of_week
        $rawSchedules = Schedule::with('doctor.user')
            ->whereHas('doctor', fn ($q) => $q->where('active', true))
            ->get();

        $schedulesByDay = [];
        foreach ($rawSchedules as $s) {
            $schedulesByDay[$s->day_of_week][] = [
                'name'      => $s->doctor->user->name ?? '—',
                'specialty' => $s->doctor->specialty  ?? '—',
                'start'     => substr($s->start_time, 0, 5),
                'end'       => substr($s->end_time, 0, 5),
            ];
        }

        // Appointment counts per day
        $apptCounts = Appointment::selectRaw('DATE(scheduled_at) as date, COUNT(*) as total')
            ->whereYear('scheduled_at', $this->year)
            ->whereMonth('scheduled_at', $this->month)
            ->whereNotIn('status', ['cancelled'])
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Build days
        $days = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date     = Carbon::createFromDate($this->year, $this->month, $d);
            $isoDay   = $date->isoWeekday();
            $schedDay = ($isoDay === 7) ? 0 : $isoDay;
            $dateStr  = $date->format('Y-m-d');

            $days[] = [
                'day'          => $d,
                'isoDay'       => $isoDay,
                'isWeekend'    => $isoDay >= 6,
                'isToday'      => $this->month === now()->month
                                  && $this->year === now()->year
                                  && $d === now()->day,
                'doctors'      => $schedulesByDay[$schedDay] ?? [],
                'appointments' => $apptCounts[$dateStr] ?? 0,
            ];
        }

        $lastIso    = Carbon::createFromDate($this->year, $this->month, $daysInMonth)->isoWeekday();
        $endPadding = ($lastIso === 7) ? 0 : 7 - $lastIso;

        $monthNames = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        return [
            'monthName'   => $monthNames[$this->month] . ' ' . $this->year,
            'startOffset' => $startOffset,
            'endPadding'  => $endPadding,
            'days'        => $days,
        ];
    }

    private function buildSelectedDayData(): ?array
    {
        if (! $this->selectedDay) return null;

        $date     = Carbon::createFromDate($this->year, $this->month, $this->selectedDay);
        $isoDay   = $date->isoWeekday();
        $schedDay = ($isoDay === 7) ? 0 : $isoDay;

        $doctors = Schedule::with('doctor.user')
            ->whereHas('doctor', fn ($q) => $q->where('active', true))
            ->where('day_of_week', $schedDay)
            ->get()
            ->map(fn ($s) => [
                'name'      => $s->doctor->user->name ?? '—',
                'specialty' => $s->doctor->specialty  ?? '—',
                'start'     => substr($s->start_time, 0, 5),
                'end'       => substr($s->end_time, 0, 5),
            ])->toArray();

        $appointments = Appointment::with(['patient', 'doctor.user'])
            ->whereDate('scheduled_at', $date->format('Y-m-d'))
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('scheduled_at')
            ->get()
            ->map(fn ($a) => [
                'patient' => $a->patient->name ?? '—',
                'doctor'  => $a->doctor->user->name ?? '—',
                'time'    => $a->scheduled_at->format('H:i'),
                'status'  => $a->status,
            ])->toArray();

        $dayNames = ['', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        return [
            'label'        => $dayNames[$isoDay] . ' ' . $this->selectedDay . ' de ' . $date->locale('es')->translatedFormat('F'),
            'doctors'      => $doctors,
            'appointments' => $appointments,
        ];
    }
}
