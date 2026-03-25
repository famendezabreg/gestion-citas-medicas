<x-filament-widgets::widget>
    <x-filament::section>

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    📅 Disponibilidad de Médicos
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Haz clic en un día para ver médicos y citas
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="previousMonth"
                    class="px-3 py-1.5 text-sm font-medium rounded-lg border
                           bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600
                           text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    ‹ Anterior
                </button>
                <span class="px-4 py-1.5 text-sm font-bold rounded-lg border
                             bg-primary-50 dark:bg-primary-900/30
                             border-primary-200 dark:border-primary-800
                             text-primary-700 dark:text-primary-300 min-w-[170px] text-center">
                    {{ $calendarData['monthName'] }}
                </span>
                <button wire:click="nextMonth"
                    class="px-3 py-1.5 text-sm font-medium rounded-lg border
                           bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600
                           text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Siguiente ›
                </button>
            </div>
        </div>

        {{-- LAYOUT PRINCIPAL --}}
        <div class="flex flex-col lg:flex-row gap-4">

            {{-- CALENDARIO --}}
            <div class="flex-1 min-w-0">

                {{-- Cabeceras días --}}
                <div class="grid grid-cols-7 gap-1 mb-1">
                    @foreach(['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'] as $dn)
                        <div class="text-center text-xs font-semibold text-gray-500 dark:text-gray-400 py-1.5 uppercase tracking-wide">
                            {{ $dn }}
                        </div>
                    @endforeach
                </div>

                {{-- Grid de días --}}
                <div class="grid grid-cols-7 gap-1">

                    {{-- Celdas vacías inicio --}}
                    @for($i = 0; $i < $calendarData['startOffset']; $i++)
                        <div class="min-h-[80px] rounded-lg bg-gray-50 dark:bg-gray-800/20"></div>
                    @endfor

                    {{-- Días del mes --}}
                    @foreach($calendarData['days'] as $dayData)
                        @php
                            $isSelected  = $selectedDay === $dayData['day'];
                            $doctorCount = count($dayData['doctors']);
                            $apptCount   = $dayData['appointments'];

                            if ($isSelected) {
                                $cellClass = 'bg-primary-100 dark:bg-primary-900/40 border-primary-500 ring-2 ring-primary-400';
                            } elseif ($dayData['isToday']) {
                                $cellClass = 'bg-blue-50 dark:bg-blue-900/20 border-blue-400';
                            } elseif ($doctorCount >= 8) {
                                $cellClass = 'bg-emerald-50 dark:bg-emerald-900/10 border-emerald-300 dark:border-emerald-700 hover:bg-emerald-100';
                            } elseif ($doctorCount >= 4) {
                                $cellClass = 'bg-teal-50 dark:bg-teal-900/10 border-teal-200 dark:border-teal-800 hover:bg-teal-100';
                            } elseif ($doctorCount >= 1) {
                                $cellClass = 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800 hover:bg-green-100';
                            } else {
                                $cellClass = 'bg-white dark:bg-gray-800/40 border-gray-200 dark:border-gray-700';
                            }
                        @endphp

                        <div wire:click="selectDay({{ $dayData['day'] }})"
                             class="min-h-[80px] rounded-lg border p-1.5 cursor-pointer transition-all duration-150 {{ $cellClass }}">

                            {{-- Número + badges --}}
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-xs font-bold
                                    {{ $dayData['isToday'] ? 'text-blue-600 dark:text-blue-400' :
                                       ($isSelected ? 'text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300') }}">
                                    {{ $dayData['day'] }}
                                    @if($dayData['isToday'])
                                        <span class="ml-0.5 text-[9px] bg-blue-500 text-white rounded px-0.5">HOY</span>
                                    @endif
                                </span>
                                <div class="flex flex-col items-end gap-0.5">
                                    @if($doctorCount > 0)
                                        <span class="text-[10px] bg-green-500 text-white rounded-full px-1.5 py-0.5 font-medium leading-none">
                                            {{ $doctorCount }}👨‍⚕️
                                        </span>
                                    @endif
                                    @if($apptCount > 0)
                                        <span class="text-[10px] bg-orange-400 text-white rounded-full px-1.5 py-0.5 font-medium leading-none">
                                            {{ $apptCount }}📋
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Nombres médicos (máx 2) --}}
                            @if($doctorCount > 0)
                                <div class="space-y-0.5">
                                    @foreach(array_slice($dayData['doctors'], 0, 2) as $doc)
                                        <div class="truncate text-[10px] rounded px-1 py-0.5 bg-white/70 dark:bg-gray-900/40 text-gray-700 dark:text-gray-300">
                                            {{ explode(' ', $doc['name'])[0] }}
                                        </div>
                                    @endforeach
                                    @if($doctorCount > 2)
                                        <div class="text-[10px] text-gray-400 dark:text-gray-500 pl-1">
                                            +{{ $doctorCount - 2 }} más
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-[10px] text-gray-300 dark:text-gray-600 italic mt-1">Sin médicos</div>
                            @endif
                        </div>
                    @endforeach

                    {{-- Celdas vacías fin --}}
                    @for($i = 0; $i < $calendarData['endPadding']; $i++)
                        <div class="min-h-[80px] rounded-lg bg-gray-50 dark:bg-gray-800/20"></div>
                    @endfor
                </div>

                {{-- Leyenda --}}
                <div class="mt-3 flex flex-wrap gap-3 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span> Médicos disponibles
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-orange-400"></span> Citas agendadas
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded border-2 border-blue-400 bg-blue-50"></span> Hoy
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded border-2 border-primary-500 bg-primary-100"></span> Seleccionado
                    </div>
                </div>
            </div>

            {{-- PANEL DE DETALLE --}}
            @if($selectedDay && $selectedDayData)
                <div class="lg:w-80 w-full shrink-0 rounded-xl border border-primary-200 dark:border-primary-800
                            bg-primary-50 dark:bg-primary-900/20 p-4 self-start"
                     wire:key="detail-{{ $selectedDay }}">

                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight">
                            📆 {{ $selectedDayData['label'] }}
                        </h3>
                        <button wire:click="selectDay({{ $selectedDay }})"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none ml-2">
                            &times;
                        </button>
                    </div>

                    {{-- Médicos --}}
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                            👨‍⚕️ Médicos disponibles ({{ count($selectedDayData['doctors']) }})
                        </p>
                        @if(count($selectedDayData['doctors']) > 0)
                            <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                                @foreach($selectedDayData['doctors'] as $doc)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-2.5 shadow-sm border border-gray-100 dark:border-gray-700">
                                        <div class="font-semibold text-sm text-gray-900 dark:text-white">{{ $doc['name'] }}</div>
                                        <div class="text-xs text-primary-600 dark:text-primary-400">{{ $doc['specialty'] }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">🕐 {{ $doc['start'] }} – {{ $doc['end'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Sin médicos disponibles.</p>
                        @endif
                    </div>

                    {{-- Citas --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                            📋 Citas agendadas ({{ count($selectedDayData['appointments']) }})
                        </p>
                        @if(count($selectedDayData['appointments']) > 0)
                            <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                                @foreach($selectedDayData['appointments'] as $appt)
                                    @php
                                        $statusColor = match($appt['status']) {
                                            'confirmed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            default     => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                        };
                                        $statusLabel = match($appt['status']) {
                                            'confirmed' => 'Confirmada',
                                            'pending'   => 'Pendiente',
                                            'completed' => 'Completada',
                                            default     => ucfirst($appt['status']),
                                        };
                                    @endphp
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-2.5 shadow-sm border border-gray-100 dark:border-gray-700">
                                        <div class="flex justify-between items-start gap-1">
                                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $appt['time'] }}</span>
                                            <span class="text-[10px] px-1.5 py-0.5 rounded-full font-medium {{ $statusColor }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-800 dark:text-gray-200 mt-1 font-medium">{{ $appt['patient'] }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">Dr. {{ $appt['doctor'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Sin citas para este día.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
