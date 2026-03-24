<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Datos Personales')->schema([
                TextEntry::make('name')->label('Nombre'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('phone')->label('Teléfono'),
                TextEntry::make('birthdate')->label('Nacimiento')->date(),
                TextEntry::make('gender')->label('Género'),
                TextEntry::make('address')->label('Dirección')->columnSpanFull(),
            ])->columns(2),

            Section::make('Expediente Clínico')->schema([
                TextEntry::make('clinicalRecord.blood_type')->label('Tipo de sangre'),
                TextEntry::make('clinicalRecord.allergies')->label('Alergias'),
                TextEntry::make('clinicalRecord.chronic_diseases')->label('Enf. crónicas'),
                TextEntry::make('clinicalRecord.notes')->label('Notas')->columnSpanFull(),
            ])->columns(2),
        ]);
    }
}