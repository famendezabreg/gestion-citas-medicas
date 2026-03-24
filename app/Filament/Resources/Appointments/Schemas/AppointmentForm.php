<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Doctor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('patient_id')
                ->label('Paciente')
                ->relationship('patient', 'name')
                ->searchable()->preload()->required(),

            Select::make('doctor_id')
                ->label('Médico')
                ->options(function () {
                    return Doctor::with('user')
                        ->where('active', true)
                        ->get()
                        ->pluck('user.name', 'id');
                })
                ->searchable()->required(),

            DateTimePicker::make('scheduled_at')
                ->label('Fecha y hora')->required(),

            Select::make('status')
                ->label('Estado')
                ->options([
                    'pending'   => 'Pendiente',
                    'confirmed' => 'Confirmada',
                    'cancelled' => 'Cancelada',
                    'completed' => 'Completada',
                ])->default('pending')->required(),

            Textarea::make('reason')
                ->label('Motivo de consulta')->columnSpanFull(),

            Textarea::make('notes')
                ->label('Notas adicionales')->columnSpanFull(),
        ]);
    }
}