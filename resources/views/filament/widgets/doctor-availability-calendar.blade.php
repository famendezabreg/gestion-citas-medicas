<x-filament-widgets::widget>
    <style>
        .med-cal {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            color: #0f172a;
        }

        .dark .med-cal {
            color: #e5e7eb;
        }

        .med-cal__hero {
            border: 1px solid #c7d2fe;
            border-radius: 28px;
            padding: 1.5rem;
            background:
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 28%),
                linear-gradient(135deg, #eef2ff 0%, #dbeafe 55%, #f8fafc 100%);
            box-shadow: 0 24px 60px -40px rgba(15, 23, 42, 0.5);
        }

        .dark .med-cal__hero {
            border-color: rgba(148, 163, 184, 0.25);
            background:
                radial-gradient(circle at top right, rgba(96, 165, 250, 0.16), transparent 30%),
                linear-gradient(135deg, rgba(15, 23, 42, 0.98) 0%, rgba(30, 41, 59, 0.98) 55%, rgba(17, 24, 39, 0.98) 100%);
            box-shadow: none;
        }

        .med-cal__hero-top {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .med-cal__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.8rem;
            margin-bottom: 0.9rem;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.12);
            color: #1d4ed8;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .dark .med-cal__eyebrow {
            background: rgba(96, 165, 250, 0.14);
            color: #bfdbfe;
        }

        .med-cal__title {
            margin: 0;
            font-size: 1.7rem;
            line-height: 1.1;
            font-weight: 800;
            color: #0f172a;
        }

        .dark .med-cal__title {
            color: #f8fafc;
        }

        .med-cal__description {
            margin: 0.65rem 0 0;
            max-width: 52rem;
            font-size: 0.98rem;
            line-height: 1.7;
            color: #475569;
        }

        .dark .med-cal__description {
            color: #cbd5e1;
        }

        .med-cal__controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .med-cal__month {
            min-width: 12rem;
            padding: 0.85rem 1rem;
            border-radius: 18px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            background: rgba(255, 255, 255, 0.72);
            color: #1e3a8a;
            font-size: 0.95rem;
            font-weight: 700;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .dark .med-cal__month {
            border-color: rgba(96, 165, 250, 0.18);
            background: rgba(15, 23, 42, 0.6);
            color: #dbeafe;
        }

        .med-cal__stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.9rem;
            margin-top: 1.25rem;
        }

        .med-cal__stat {
            border-radius: 22px;
            padding: 1rem 1.1rem;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
        }

        .dark .med-cal__stat {
            border-color: rgba(148, 163, 184, 0.18);
            background: rgba(15, 23, 42, 0.58);
        }

        .med-cal__stat-label {
            margin: 0;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
        }

        .dark .med-cal__stat-label {
            color: #94a3b8;
        }

        .med-cal__stat-value {
            margin: 0.45rem 0 0;
            font-size: 1.9rem;
            line-height: 1;
            font-weight: 800;
            color: #0f172a;
        }

        .dark .med-cal__stat-value {
            color: #f8fafc;
        }

        .med-cal__stat-copy {
            margin: 0.45rem 0 0;
            font-size: 0.86rem;
            line-height: 1.5;
            color: #475569;
        }

        .dark .med-cal__stat-copy {
            color: #cbd5e1;
        }

        .med-cal__board {
            border-radius: 28px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(255, 255, 255, 0.88);
            padding: 1rem;
            box-shadow: 0 24px 60px -42px rgba(15, 23, 42, 0.55);
            overflow-x: auto;
        }

        .dark .med-cal__board {
            border-color: rgba(148, 163, 184, 0.16);
            background: rgba(15, 23, 42, 0.86);
            box-shadow: none;
        }

        .med-cal__weekdays,
        .med-cal__grid {
            min-width: 980px;
        }

        .med-cal__weekdays {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .med-cal__weekday {
            padding: 0.85rem 0.5rem;
            border-radius: 18px;
            background: #e2e8f0;
            color: #334155;
            text-align: center;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .dark .med-cal__weekday {
            background: rgba(30, 41, 59, 0.95);
            color: #cbd5e1;
        }

        .med-cal__grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .med-cal__empty,
        .med-cal__cell {
            min-height: 13rem;
            border-radius: 22px;
        }

        .med-cal__empty {
            border: 1px dashed rgba(148, 163, 184, 0.3);
            background: rgba(226, 232, 240, 0.45);
        }

        .dark .med-cal__empty {
            border-color: rgba(148, 163, 184, 0.18);
            background: rgba(30, 41, 59, 0.45);
        }

        .med-cal__cell {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
            padding: 0.95rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.98) 100%);
        }

        .dark .med-cal__cell {
            border-color: rgba(148, 163, 184, 0.18);
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.95) 0%, rgba(17, 24, 39, 0.95) 100%);
        }

        .med-cal__cell--today {
            border-color: rgba(37, 99, 235, 0.42);
            background: linear-gradient(180deg, rgba(219, 234, 254, 0.95) 0%, rgba(239, 246, 255, 0.98) 100%);
            box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.12);
        }

        .dark .med-cal__cell--today {
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.98) 0%, rgba(30, 64, 175, 0.16) 100%);
            border-color: rgba(96, 165, 250, 0.4);
        }

        .med-cal__cell-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .med-cal__day-number {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .dark .med-cal__day-number {
            color: #f8fafc;
        }

        .med-cal__day-label {
            margin: 0.18rem 0 0;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
        }

        .dark .med-cal__day-label {
            color: #94a3b8;
        }

        .med-cal__count {
            padding: 0.35rem 0.55rem;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.12);
            color: #1d4ed8;
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .dark .med-cal__count {
            background: rgba(96, 165, 250, 0.14);
            color: #bfdbfe;
        }

        .med-cal__doctor-list {
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
        }

        .med-cal__doctor {
            border-radius: 16px;
            padding: 0.7rem 0.8rem;
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.09);
        }

        .dark .med-cal__doctor {
            background: rgba(30, 64, 175, 0.18);
            border-color: rgba(96, 165, 250, 0.18);
        }

        .med-cal__doctor-name {
            margin: 0;
            font-size: 0.83rem;
            font-weight: 700;
            color: #0f172a;
        }

        .dark .med-cal__doctor-name {
            color: #eff6ff;
        }

        .med-cal__doctor-time {
            margin: 0.25rem 0 0;
            font-size: 0.75rem;
            color: #334155;
        }

        .dark .med-cal__doctor-time {
            color: #bfdbfe;
        }

        .med-cal__more {
            margin-top: 0.15rem;
            font-size: 0.73rem;
            font-weight: 700;
            color: #475569;
        }

        .dark .med-cal__more {
            color: #cbd5e1;
        }

        .med-cal__empty-copy {
            margin-top: auto;
            padding: 0.9rem 0.8rem;
            border-radius: 16px;
            border: 1px dashed rgba(148, 163, 184, 0.28);
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
            background: rgba(248, 250, 252, 0.9);
        }

        .dark .med-cal__empty-copy {
            border-color: rgba(148, 163, 184, 0.18);
            color: #94a3b8;
            background: rgba(15, 23, 42, 0.45);
        }

        .med-cal__legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            font-size: 0.78rem;
            color: #475569;
        }

        .dark .med-cal__legend {
            color: #cbd5e1;
        }

        .med-cal__legend-item {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }

        .med-cal__legend-dot {
            width: 0.8rem;
            height: 0.8rem;
            border-radius: 999px;
        }

        .med-cal__legend-dot--doctor {
            background: #60a5fa;
        }

        .med-cal__legend-dot--today {
            background: #2563eb;
        }

        @media (max-width: 1024px) {
            .med-cal__stats {
                grid-template-columns: 1fr;
            }

            .med-cal__month {
                min-width: 100%;
            }
        }
    </style>

    <x-filament::section>
        <div class="med-cal">
            <div class="med-cal__hero">
                <div class="med-cal__hero-top">
                    <div>
                        <div class="med-cal__eyebrow">Punto extra | Vista calendario</div>
                        <h2 class="med-cal__title">Disponibilidad mensual de medicos</h2>
                        <p class="med-cal__description">
                            Implementacion de un calendario mensual en el panel de Filament para visualizar la disponibilidad de los medicos de forma intuitiva.
                        </p>
                    </div>

                    <div class="med-cal__controls">
                        <x-filament::button
                            wire:click="previousMonth"
                            color="gray"
                            size="sm"
                            icon="heroicon-m-chevron-left"
                        >
                            Mes anterior
                        </x-filament::button>

                        <div class="med-cal__month">{{ $monthName }}</div>

                        <x-filament::button
                            wire:click="nextMonth"
                            color="gray"
                            size="sm"
                            icon="heroicon-m-chevron-right"
                            icon-position="after"
                        >
                            Mes siguiente
                        </x-filament::button>
                    </div>
                </div>

                <div class="med-cal__stats">
                    <div class="med-cal__stat">
                        <p class="med-cal__stat-label">Medicos activos</p>
                        <p class="med-cal__stat-value">{{ $activeDoctorsCount }}</p>
                        <p class="med-cal__stat-copy">Con horarios visibles en el calendario.</p>
                    </div>

                    <div class="med-cal__stat">
                        <p class="med-cal__stat-label">Bloques registrados</p>
                        <p class="med-cal__stat-value">{{ $scheduleBlocksCount }}</p>
                        <p class="med-cal__stat-copy">Segmentos de horario cargados para los medicos.</p>
                    </div>

                    <div class="med-cal__stat">
                        <p class="med-cal__stat-label">Dias con cobertura</p>
                        <p class="med-cal__stat-value">{{ $coveredDaysCount }}</p>
                        <p class="med-cal__stat-copy">Dias de la semana que tienen atencion programada.</p>
                    </div>
                </div>
            </div>

            <div class="med-cal__board">
                <div class="med-cal__weekdays">
                    @foreach (['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'] as $dayName)
                        <div class="med-cal__weekday">{{ $dayName }}</div>
                    @endforeach
                </div>

                <div class="med-cal__grid">
                    @for ($i = 0; $i < $startOffset; $i++)
                        <div class="med-cal__empty"></div>
                    @endfor

                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $date = \Carbon\Carbon::createFromDate($year, $month, $day);
                            $isoDay = $date->isoWeekday();
                            $schedDay = $isoDay === 7 ? 0 : $isoDay;
                            $doctors = $schedulesByDay[$schedDay] ?? [];
                            $isToday = $isCurrentMonth && $day === $today;
                        @endphp

                        <div class="med-cal__cell {{ $isToday ? 'med-cal__cell--today' : '' }}">
                            <div class="med-cal__cell-head">
                                <div>
                                    <p class="med-cal__day-number">{{ $day }}</p>
                                    <p class="med-cal__day-label">{{ $date->translatedFormat('M') }}</p>
                                </div>

                                @if (count($doctors))
                                    <span class="med-cal__count">{{ count($doctors) }} medico(s)</span>
                                @endif
                            </div>

                            @if (count($doctors))
                                <div class="med-cal__doctor-list">
                                    @foreach (array_slice($doctors, 0, 3) as $doctor)
                                        <div class="med-cal__doctor">
                                            <p class="med-cal__doctor-name">{{ $doctor['name'] }}</p>
                                            <p class="med-cal__doctor-time">{{ $doctor['start'] }} - {{ $doctor['end'] }}</p>
                                        </div>
                                    @endforeach

                                    @if (count($doctors) > 3)
                                        <div class="med-cal__more">+{{ count($doctors) - 3 }} medico(s) mas</div>
                                    @endif
                                </div>
                            @else
                                <div class="med-cal__empty-copy">Sin disponibilidad</div>
                            @endif
                        </div>
                    @endfor

                    @php
                        $lastDate = \Carbon\Carbon::createFromDate($year, $month, $daysInMonth);
                        $lastIso = $lastDate->isoWeekday();
                        $endPadding = $lastIso === 7 ? 0 : 7 - $lastIso;
                    @endphp

                    @for ($i = 0; $i < $endPadding; $i++)
                        <div class="med-cal__empty"></div>
                    @endfor
                </div>
            </div>

            <div class="med-cal__legend">
                <div class="med-cal__legend-item">
                    <span class="med-cal__legend-dot med-cal__legend-dot--doctor"></span>
                    <span>Horario medico disponible</span>
                </div>

                <div class="med-cal__legend-item">
                    <span class="med-cal__legend-dot med-cal__legend-dot--today"></span>
                    <span>Dia actual</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
