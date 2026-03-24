<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialty', 'license_number', 'active'];
    protected $casts = ['active' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function isAvailableAt(\Carbon\Carbon $dateTime): bool
    {
        $dayOfWeek = $dateTime->dayOfWeek;
        $time      = $dateTime->format('H:i:s');

        return $this->schedules()
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>', $time)
            ->exists();
    }
}