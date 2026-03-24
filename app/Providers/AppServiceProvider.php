<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Policies\AppointmentPolicy;
use App\Policies\PatientPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar Policies para control de acceso por roles
        Gate::policy(Patient::class, PatientPolicy::class);
        Gate::policy(Appointment::class, AppointmentPolicy::class);
    }
}
