<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'doctor_id'    => 'required|exists:doctors,id',
            'scheduled_at' => 'required|date|after:now',
            'reason'       => 'nullable|string|max:500',
        ]);

        $scheduledAt = Carbon::parse($validated['scheduled_at']);
        $doctor      = Doctor::with('schedules')->findOrFail($validated['doctor_id']);

        // Validar que el médico tenga horario en ese momento
        if (! $doctor->isAvailableAt($scheduledAt)) {
            throw ValidationException::withMessages([
                'scheduled_at' => [
                    "El médico no tiene horario disponible el " .
                    $scheduledAt->locale('es')->translatedFormat('l') .
                    " a las " . $scheduledAt->format('H:i') . "."
                ],
            ]);
        }

        // Validar que no haya cita duplicada en el mismo bloque de hora
        $slotStart = $scheduledAt->copy()->startOfHour();
        $slotEnd   = $scheduledAt->copy()->endOfHour();

        $duplicate = Appointment::where('doctor_id', $doctor->id)
            ->whereBetween('scheduled_at', [$slotStart, $slotEnd])
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'scheduled_at' => [
                    "El médico ya tiene una cita en ese bloque ({$slotStart->format('H:i')} - {$slotEnd->format('H:i')})."
                ],
            ]);
        }

        $appointment = Appointment::create([
            'patient_id'   => $validated['patient_id'],
            'doctor_id'    => $validated['doctor_id'],
            'scheduled_at' => $scheduledAt,
            'status'       => 'pending',
            'reason'       => $validated['reason'] ?? null,
        ]);

        return response()->json([
            'message'     => 'Cita creada exitosamente.',
            'appointment' => $appointment->load(['patient', 'doctor.user']),
        ], 201);
    }

    public function index()
    {
        return response()->json(
            Appointment::with(['patient', 'doctor.user'])
                ->orderBy('scheduled_at')
                ->paginate(20)
        );
    }
}