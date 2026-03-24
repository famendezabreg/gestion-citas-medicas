<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                📅 Disponibilidad de Médicos — {{ $monthName }}
            </h2>
            <div class="flex gap-2">
                <x-filament::button
                    wire:click="previousMonth"
                    color="gray"
                    size="sm"
                    icon="heroicon-m-chevron-left"
                >
                    Anterior
                </x-filament::button>
                <x-filament::button
                    wire:click="nextMonth"
                    color="gray"
                    size="sm"
                    icon="heroicon-m-chevron-right"
                    icon-position="after"
                >
                    Siguiente
                </x-filament::button>
            </div>
        </div>

        {{-- Day headers --}}
        <div class="grid grid-cols-7 gap-1 mb-1">
            @foreach(['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $dayName)
                <div class="text-center text-xs font-semibold text-gray-500 dark:text-gray-400 py-2 uppercase tracking-wide">
                    {{ $dayName }}
                </div>
            @endforeach
        </div>

        {{-- Calendar grid --}}
        <div class="grid grid-cols-7 gap-1">

            {{-- Empty cells before first day --}}
            @for($i = 0; $i < $startOffset; $i++)
                <div class="min-h-24 rounded-lg bg-gray-50 dark:bg-gray-800/30 opacity-40"></div>
            @endfor

            {{-- Day cells --}}
            @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    // dayOfWeek for this date: Carbon isoWeekday => 1=Mon...7=Sun, stored as 1-6,0
                    $date       = \Carbon\Carbon::createFromDate($year, $month, $day);
                    $isoDay     = $date->isoWeekday(); // 1=Mon ... 7=Sun
                    // Map isoWeekday to our schedule day_of_week (1=Mon...6=Sat, 0=Sun)
                    $schedDay   = ($isoDay === 7) ? 0 : $isoDay;
                    $doctors    = $schedulesByDay[$schedDay] ?? [];
                    $isToday    = $isCurrentMonth && $day === $today;
                    $isWeekend  = $isoDay >= 6;
                @endphp

                <div class="min-h-24 rounded-lg border p-1.5 text-sm
                    {{ $isToday
                        ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20'
                        : ($isWeekend
                            ? 'border-gray-200 bg-gray-50 dark:bg-gray-800/30 dark:border-gray-700'
                            : 'border-gray-200 bg-white dark:bg-gray-800/50 dark:border-gray-700') }}">

                    {{-- Day number --}}
                    <div class="flex justify-between items-start mb-1">
                        <span class="font-semibold text-xs
                            {{ $isToday
                                ? 'text-primary-600 dark:text-primary-400'
                                : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $day }}
                        </span>
                        @if(count($doctors) > 0)
                            <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                                {{ count($doctors) }}
                            </span>
                        @endif
                    </div>

                    {{-- Doctors available --}}
                    @if(count($doctors) > 0)
                        <div class="space-y-0.5 overflow-hidden">
                            @foreach(array_slice($doctors, 0, 3) as $doctor)
                                <div class="truncate text-xs rounded px-1 py-0.5
                                    bg-blue-100 text-blue-800
                                    dark:bg-blue-900/40 dark:text-blue-300"
                                    title="{{ $doctor['name'] }} {{ $doctor['start'] }}-{{ $doctor['end'] }}">
                                    {{ $doctor['name'] }}
                                </div>
                            @endforeach
                            @if(count($doctors) > 3)
                                <div class="text-xs text-gray-400 dark:text-gray-500 pl-1">
                                    +{{ count($doctors) - 3 }} más
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-xs text-gray-300 dark:text-gray-600 italic mt-1">
                            Sin médicos
                        </div>
                    @endif
                </div>
            @endfor

            {{-- Empty cells after last day --}}
            @php
                $lastDate   = \Carbon\Carbon::createFromDate($year, $month, $daysInMonth);
                $lastIso    = $lastDate->isoWeekday();
                $endPadding = ($lastIso === 7) ? 0 : 7 - $lastIso;
            @endphp
            @for($i = 0; $i < $endPadding; $i++)
                <div class="min-h-24 rounded-lg bg-gray-50 dark:bg-gray-800/30 opacity-40"></div>
            @endfor
        </div>

        {{-- Legend --}}
        <div class="mt-4 flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-1">
                <div class="w-3 h-3 rounded bg-blue-100 dark:bg-blue-900/40"></div>
                <span>Médico disponible</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-3 h-3 rounded border border-primary-500 bg-primary-50 dark:bg-primary-900/20"></div>
                <span>Hoy</span>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
