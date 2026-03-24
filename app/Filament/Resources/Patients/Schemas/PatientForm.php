<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Datos Personales')->schema([
                TextInput::make('name')->label('Nombre completo')->required()->maxLength(255),
                TextInput::make('email')->label('Correo')->email()->unique(ignoreRecord: true),
                TextInput::make('phone')->label('Teléfono'),
                DatePicker::make('birthdate')->label('Fecha de nacimiento'),
                Select::make('gender')->label('Género')
                    ->options(['M' => 'Masculino', 'F' => 'Femenino', 'otro' => 'Otro']),
                Textarea::make('address')->label('Dirección')->columnSpanFull(),
            ])->columns(2),
        ]);
    }
}