<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .cal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            .cal-header__title {
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--gray-950, #0f172a);
            }
            .dark .cal-header__title { color: #f1f5f9; }
            .cal-header__sub {
                font-size: 0.82rem;
                color: #64748b;
                margin-top: 0.2rem;
            }
            .dark .cal-header__sub { color: #94a3b8; }

            .cal-stats {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }
            .cal-stat {
                padding: 0.9rem 1rem;
                border-radius: 12px;
                border: 1px solid rgba(148,163,184,0.2);
                background: rgba(248,250,252,0.8);
            }
            .dark .cal-stat {
                background: rgba(30,41,59,0.5);
                border-color: rgba(148,163,184,0.15);
            }
            .cal-stat__label {
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: #64748b;
            }
            .dark .cal-stat__label { color: #94a3b8; }
            .cal-stat__value {
                font-size: 1.6rem;
                font-weight: 800;
                color: #0f172a;
                line-height: 1.2;
                margin-top: 0.3rem;
            }
            .dark .cal-stat__value { color: #f1f5f9; }
            .cal-stat__desc {
                font-size: 0.78rem;
                color: #64748b;
                margin-top: 0.2rem;
            }
            .dark .cal-stat__desc { color: #94a3b8; }

            .cal-controls {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            .cal-month-label {
                min-width: 10rem;
                text-align: center;
                font-size: 0.95rem;
                font-weight: 700;
                color: #0f172a;
                padding: 0.6rem 1rem;
                border-radius: 10px;
                border: 1px solid rgba(148,163,184,0.25);
                background: rgba(248,250,252,0.9);
            }
            .dark .cal-month-label {
                color: #f1f5f9;
                background: rgba(30,41,59,0.6);
                border-color: rgba(148,163,184,0.2);
            }

            .cal-grid-wrap { overflow-x: auto; }

            .cal-weekdays,
            .cal-grid {
                min-width: 700px;
            }
            .cal-weekdays {
                display: grid;
                grid-template-columns: repeat(7, minmax(0, 1fr));
                gap: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .cal-weekday {
                padding: 0.6rem 0.4rem;
                border-radius: 8px;
                background: rgba(241,245,249,0.9);
                text-align: center;
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.07em;
                text-transform: uppercase;
                color: #475569;
            }
            .dark .cal-weekday {
                background: rgba(30,41,59,0.7);
                color: #94a3b8;
            }

            .cal-grid {
                display: grid;
                grid-template-columns: repeat(7, minmax(0, 1fr));
                gap: 0.5rem;
            }

            .cal-empty {
                min-height: 7rem;
                border-radius: 10px;
                border: 1px dashed rgba(148,163,184,0.2);
                background: rgba(241,245,249,0.3);
            }
            .dark .cal-empty {
                border-color: rgba(148,163,184,0.12);
                background: rgba(15,23,42,0.3);
            }

            .cal-cell {
                min-height: 7rem;
                border-radius: 10px;
                border: 1px solid rgba(148,163,184,0.2);
                background: rgba(255,255,255,0.9);
                padding: 0.6rem;
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
            }
            .dark .cal-cell {
                background: rgba(15,23,42,0.6);
                border-color: rgba(148,163,184,0.15);
            }
            .cal-cell--today {
                border-color: rgba(59,130,246,0.5);
                background: rgba(239,246,255,0.95);
            }
            .dark .cal-cell--today {
                background: rgba(30,58,138,0.2);
                border-color: rgba(96,165,250,0.4);
            }

            .cal-cell__head {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .cal-cell__day {
                font-size: 0.95rem;
                font-weight: 800;
                color: #0f172a;
            }
            .dark .cal-cell__day { color: #f1f5f9; }
            .cal-cell__day--today { color: #2563eb; }
            .dark .cal-cell__day--today { color: #60a5fa; }

            .cal-cell__badge {
                font-size: 0.65rem;
                font-weight: 700;
                padding: 0.2rem 0.45rem;
                border-radius: 999px;
                background: rgba(59,130,246,0.12);
                color: #2563eb;
            }
            .dark .cal-cell__badge {
                background: rgba(96,165,250,0.15);
                color: #93c5fd;
            }

            .cal-doctor {
                font-size: 0.72rem;
                padding: 0.35rem 0.5rem;
                border-radius: 7px;
                background: rgba(59,130,246,0.08);
                border: 1px solid rgba(59,130,246,0.12);
                color: #1e40af;
                line-height: 1.3;
            }
            .dark .cal-doctor {
                background: rgba(30,64,175,0.2);
                border-color: rgba(96,165,250,0.2);
                color: #bfdbfe;
            }
            .cal-doctor__name {
                font-weight: 700;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .cal-doctor__time {
                font-size: 0.68rem;
                opacity: 0.8;
            }

            .cal-more {
                font-size: 0.68rem;
                font-weight: 600;
                color: #64748b;
                padding: 0.2rem 0.4rem;
            }
            .dark .cal-more { color: #94a3b8; }

            .cal-no-doctors {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.72rem;
                color: #94a3b8;
            }

            .cal-legend {
                display: flex;
                gap: 1.2rem;
                flex-wrap: wrap;
                margin-top: 1rem;
                font-size: 0.78rem;
                color: #64748b;
            }
            .dark .cal-legend { color: #94a3b8; }
            .cal-legend__item {
                display: flex;
                align-items: center;
                gap: 0.45rem;
            }
            .cal-legend__dot {
                width: 0.7rem;
                height: 0.7rem;
                border-radius: 999px;
            }

            @media (max-width: 768px) {
                .cal-stats { grid-template-columns: 1fr; }
                .cal-controls { flex-wrap: wrap; }
                .cal-month-label { min-width: 100%; text-align: center; }
            }
        </style>

        <div>
            {{-- Header --}}
            <div class="cal-header">
                <div>
                    <div class="cal-header__title">📅 Disponibilidad mensual de médicos</div>
                    <div class="cal-header__sub">Visualiza qué médicos atienden cada día del mes</div>
                </div>
                <div class="cal-controls">
                    <x-filament::button wire:click="previousMonth" color="gray" size="sm" icon="heroicon-m-chevron-left">
                        Anterior
                    </x-filament::button>
                    <div class="cal-month-label">{{ $monthName }}</div>
                    <x-filament::button wire:click="nextMonth" color="gray" size="sm" icon="heroicon-m-chevron-right" icon-position="after">
                        Siguiente
                    </x-filament::button>
                </div>
            </div>

            {{-- Stats --}}
            <div class="cal-stats">
                <div class="cal-stat">
                    <div class="cal-stat__label">Médicos activos</div>
                    <div class="cal-stat__value">{{ $activeDoctorsCount }}</div>
                    <div class="cal-stat__desc">Con horarios registrados</div>
                </div>
                <div class="cal-stat">
                    <div class="cal-stat__label">Bloques de horario</div>
                    <div class="cal-stat__value">{{ $scheduleBlocksCount }}</div>
                    <div class="cal-stat__desc">Segmentos de atención cargados</div>
                </div>
                <div class="cal-stat">
                    <div class="cal-stat__label">Días con cobertura</div>
                    <div class="cal-stat__value">{{ $coveredDaysCount }}</div>
                    <div class="cal-stat__desc">De 7 días de la semana</div>
                </div>
            </div>

            {{-- Calendario --}}
            <div class="cal-grid-wrap">
                <div class="cal-weekdays">
                    @foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $dayName)
                        <div class="cal-weekday">{{ $dayName }}</div>
                    @endforeach
                </div>

                <div class="cal-grid">
                    @for ($i = 0; $i < $startOffset; $i++)
                        <div class="cal-empty"></div>
                    @endfor

                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $date = \Carbon\Carbon::createFromDate($year, $month, $day);
                            $isoDay = $date->isoWeekday();
                            $schedDay = $isoDay === 7 ? 0 : $isoDay;
                            $doctors = $schedulesByDay[$schedDay] ?? [];
                            $isToday = $isCurrentMonth && $day === $today;
                            $visible = array_slice($doctors, 0, 2);
                            $extra = count($doctors) - count($visible);
                        @endphp

                        <div class="cal-cell {{ $isToday ? 'cal-cell--today' : '' }}">
                            <div class="cal-cell__head">
                                <span class="cal-cell__day {{ $isToday ? 'cal-cell__day--today' : '' }}">{{ $day }}</span>
                                @if (count($doctors))
                                    <span class="cal-cell__badge">{{ count($doctors) }} drs.</span>
                                @endif
                            </div>

                            @if (count($doctors))
                                @foreach ($visible as $doctor)
                                    <div class="cal-doctor">
                                        <div class="cal-doctor__name">{{ $doctor['name'] }}</div>
                                        <div class="cal-doctor__time">{{ $doctor['start'] }} – {{ $doctor['end'] }}</div>
                                    </div>
                                @endforeach
                                @if ($extra > 0)
                                    <div class="cal-more">+{{ $extra }} más</div>
                                @endif
                            @else
                                <div class="cal-no-doctors">Sin atención</div>
                            @endif
                        </div>
                    @endfor

                    @php
                        $lastDate = \Carbon\Carbon::createFromDate($year, $month, $daysInMonth);
                        $lastIso = $lastDate->isoWeekday();
                        $endPadding = $lastIso === 7 ? 0 : 7 - $lastIso;
                    @endphp
                    @for ($i = 0; $i < $endPadding; $i++)
                        <div class="cal-empty"></div>
                    @endfor
                </div>
            </div>

            {{-- Leyenda --}}
            <div class="cal-legend">
                <div class="cal-legend__item">
                    <span class="cal-legend__dot" style="background:#60a5fa"></span>
                    <span>Médico disponible</span>
                </div>
                <div class="cal-legend__item">
                    <span class="cal-legend__dot" style="background:#2563eb"></span>
                    <span>Día actual</span>
                </div>
                <div class="cal-legend__item">
                    <span class="cal-legend__dot" style="background:rgba(148,163,184,0.4)"></span>
                    <span>Sin atención programada</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>