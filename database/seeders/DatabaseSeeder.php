<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\ClinicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear roles
        foreach (['admin', 'medico', 'asistente'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Crear admin
        $admin = User::factory()->create([
            'name'  => 'Administrador',
            'email' => 'admin@clinica.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        // 3. Crear 20 médicos con horarios (mínimo 20 registros por tabla)
        $days = [1, 2, 3, 4, 5, 6]; // Lunes a Sábado
        $specialties = ['Medicina General', 'Pediatría', 'Cardiología', 'Dermatología', 'Neurología',
                        'Ginecología', 'Traumatología', 'Oftalmología', 'Psiquiatría', 'Endocrinología'];
        for ($i = 1; $i <= 20; $i++) {
            $user = User::factory()->create([
                'password' => bcrypt('password123'),
            ]);
            $user->assignRole('medico');

            $doctor = Doctor::create([
                'user_id'        => $user->id,
                'specialty'      => fake()->randomElement($specialties),
                'license_number' => 'MED-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'active'         => true,
            ]);

            // Cada médico atiende entre 2 y 4 días distintos
            $doctorDays = fake()->randomElements($days, rand(2, 4));
            foreach ($doctorDays as $day) {
                Schedule::create([
                    'doctor_id'   => $doctor->id,
                    'day_of_week' => $day,
                    'start_time'  => '08:00:00',
                    'end_time'    => '12:00:00',
                ]);
            }
        }

        // 4. Crear 2 asistentes
        for ($i = 0; $i < 2; $i++) {
            $user = User::factory()->create([
                'password' => bcrypt('password123'),
            ]);
            $user->assignRole('asistente');
        }

        // 5. Crear 30 pacientes con expediente clínico
        Patient::factory(30)->create()->each(function (Patient $patient) {
            ClinicalRecord::create([
                'patient_id'       => $patient->id,
                'blood_type'       => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'allergies'        => fake()->optional(0.5)->sentence(),
                'chronic_diseases' => fake()->optional(0.3)->sentence(),
                'notes'            => fake()->optional(0.4)->paragraph(),
            ]);
        });

        // 6. Crear 50 citas
        $doctors  = Doctor::all();
        $patients = Patient::all();
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $created  = 0;
        $attempts = 0;

        while ($created < 50 && $attempts < 300) {
            $attempts++;
            $doctor   = $doctors->random();
            $patient  = $patients->random();
            $schedule = $doctor->schedules()->inRandomOrder()->first();

            if (! $schedule) continue;

            // Generar fecha en los próximos 30 días que coincida con el día del horario
            $targetDay = $schedule->day_of_week;
            $date = now()->next(\Carbon\Carbon::getDays()[$targetDay]);
            $hour = rand(8, 11);
            $scheduledAt = $date->copy()->setHour($hour)->setMinute(0)->setSecond(0);

            // Saltar si ya existe cita en ese slot
            $taken = Appointment::where('doctor_id', $doctor->id)
                ->where('scheduled_at', $scheduledAt)
                ->exists();

            if ($taken) continue;

            Appointment::create([
                'patient_id'   => $patient->id,
                'doctor_id'    => $doctor->id,
                'scheduled_at' => $scheduledAt,
                'status'       => fake()->randomElement($statuses),
                'reason'       => fake()->sentence(),
            ]);

            $created++;
        }

        $this->command->info("✅ Seeder completo: {$created} citas, 30 pacientes, 20 médicos, 2 asistentes.");
    }
}