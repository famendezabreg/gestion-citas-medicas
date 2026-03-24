<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Solo admin puede eliminar (médico no puede eliminar por auditoría)
            DeleteAction::make()
                ->visible(fn () => auth()->user()->hasRole('admin')),
            ForceDeleteAction::make()
                ->visible(fn () => auth()->user()->hasRole('admin')),
            RestoreAction::make()
                ->visible(fn () => auth()->user()->hasRole('admin')),
        ];
    }
}
