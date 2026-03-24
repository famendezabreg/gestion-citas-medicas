<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    /**
     * Cualquier usuario autenticado con acceso al panel puede ver pacientes.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'medico', 'asistente']);
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->hasAnyRole(['admin', 'medico', 'asistente']);
    }

    /**
     * Solo admin y asistente pueden crear pacientes.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'asistente']);
    }

    /**
     * Solo admin y asistente pueden editar datos del paciente.
     * El médico NO puede editar (ni el expediente clínico asociado).
     */
    public function update(User $user, Patient $patient): bool
    {
        return $user->hasAnyRole(['admin', 'asistente']);
    }

    /**
     * Solo el admin puede eliminar pacientes.
     * El médico NO puede eliminar registros (auditoría del sistema).
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }
}
