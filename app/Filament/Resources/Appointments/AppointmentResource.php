<?php

namespace App\Filament\Resources\Appointments;

use App\Filament\Resources\Appointments\Pages\CreateAppointment;
use App\Filament\Resources\Appointments\Pages\EditAppointment;
use App\Filament\Resources\Appointments\Pages\ListAppointments;
use App\Filament\Resources\Appointments\Schemas\AppointmentForm;
use App\Filament\Resources\Appointments\Tables\AppointmentsTable;
use App\Models\Appointment;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Citas';
    protected static ?string $modelLabel = 'Cita';

    // AppointmentPolicy (registrada en AppServiceProvider) se aplica automáticamente:
    // - Médico: solo puede ver (no editar ni eliminar)
    // - Asistente: puede crear y editar
    // - Admin: control total

    public static function form(Schema $schema): Schema
    {
        return AppointmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentsTable::configure($table)
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if ($user->hasRole('medico') && $user->doctor) {
                    $query->where('doctor_id', $user->doctor->id);
                }
            });
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAppointments::route('/'),
            'create' => CreateAppointment::route('/create'),
            'edit'   => EditAppointment::route('/{record}/edit'),
        ];
    }
}