<?php

namespace App\Filament\Resources\Patients;

use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\EditPatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Filament\Resources\Patients\Schemas\PatientForm;
use App\Filament\Resources\Patients\Schemas\PatientInfolist;
use App\Filament\Resources\Patients\Tables\PatientsTable;
use App\Models\Patient;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pacientes';
    protected static ?string $modelLabel = 'Paciente';

    // Filament llama automáticamente a la PatientPolicy registrada en AppServiceProvider
    // canCreate(), canEdit(), canDelete() se resuelven desde la Policy sin código extra aquí.

    public static function form(Schema $schema): Schema
    {
        return PatientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PatientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view'   => ViewPatient::route('/{record}'),
            'edit'   => EditPatient::route('/{record}/edit'),
        ];
    }
}