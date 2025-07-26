<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'training_session_id',
        'user_id',
        'registered_at',
        'attendance_status',
        'payment_status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
        ];
    }

    /**
     * Get the training session that owns the registration.
     */
    public function trainingSession()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    /**
     * Get the member that owns the registration.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user that owns the registration.
     * Alias for member() for easier access
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
