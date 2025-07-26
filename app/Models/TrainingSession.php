<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coach_id',
        'session_name',
        'description',
        'start_time',
        'end_time',
        'location',
        'max_capacity',
        'price',
        'session_type',
        'skill_level',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the coach that owns the training session.
     */
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    /**
     * Get the session registrations for this training session.
     */
    public function sessionRegistrations()
    {
        return $this->hasMany(SessionRegistration::class);
    }

    /**
     * Alias for sessionRegistrations - Get the registrations for this training session.
     */
    public function registrations()
    {
        return $this->hasMany(SessionRegistration::class);
    }
}
