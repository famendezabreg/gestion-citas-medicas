<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'medico', 'asistente']);
    }

    public function view(User $user, Appointment $appointment): bool
    {
        return $user->hasAnyRole(['admin', 'medico', 'asistente']);
    }

    /**
     * Admin y asistente pueden crear citas.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'asistente']);
    }

    /**
     * Admin y asistente pueden editar citas.
     * El médico solo puede ver su agenda, no editarla desde el panel.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        return $user->hasAnyRole(['admin', 'asistente']);
    }

    /**
     * El médico NO puede eliminar registros (auditoría del sistema).
     * Solo admin puede eliminar.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Appointment $appointment): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Appointment $appointment): bool
    {
        return $user->hasRole('admin');
    }
}
