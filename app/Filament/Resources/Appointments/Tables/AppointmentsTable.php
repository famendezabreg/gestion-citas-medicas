<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Models\Doctor;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')
                    ->label('Fecha y hora')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('patient.name')
                    ->label('Paciente')->searchable()->sortable(),
                TextColumn::make('doctor.user.name')
                    ->label('Médico')->searchable()
                    ->visible(fn () => ! auth()->user()->hasRole('medico')),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'primary',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'   => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'cancelled' => 'Cancelada',
                        'completed' => 'Completada',
                        default     => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending'   => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'cancelled' => 'Cancelada',
                        'completed' => 'Completada',
                    ]),
                // Asistentes y admins pueden filtrar por médico
                SelectFilter::make('doctor_id')
                    ->label('Médico')
                    ->options(function () {
                        return Doctor::with('user')
                            ->where('active', true)
                            ->get()
                            ->pluck('user.name', 'id');
                    })
                    ->searchable()
                    ->hidden(fn () => auth()->user()->hasRole('medico')),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn () => auth()->user()->hasRole('admin')),
            ]);
    }
}