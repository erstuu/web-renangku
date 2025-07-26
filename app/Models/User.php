<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'approval_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is coach
     */
    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    /**
     * Check if user is member
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get the user's display name (alias for full_name)
     */
    public function getNameAttribute(): string
    {
        return $this->full_name;
    }

    /**
     * Scope to filter by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the coach profile for the user.
     */
    public function coachProfile()
    {
        return $this->hasOne(CoachProfile::class);
    }

    /**
     * Get the member profile for the user.
     */
    public function memberProfile()
    {
        return $this->hasOne(MemberProfile::class);
    }

    /**
     * Get the training sessions for coach.
     */
    public function trainingSessions()
    {
        return $this->hasMany(TrainingSession::class, 'coach_id');
    }

    /**
     * Get the session registrations for member.
     */
    public function sessionRegistrations()
    {
        return $this->hasMany(SessionRegistration::class, 'user_id');
    }

    /**
     * Get the announcements created by the admin.
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'admin_id');
    }

    /**
     * Get the data change requests made by the user.
     */
    public function dataChangeRequests()
    {
        return $this->hasMany(DataChangeRequest::class);
    }

    /**
     * Check if user is a coach with pending approval
     */
    public function isPendingApproval()
    {
        return $this->role === 'coach' && $this->approval_status === 'pending';
    }

    /**
     * Check if user is approved
     */
    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    /**
     * Check if user needs to complete profile
     */
    public function needsProfileCompletion()
    {
        if ($this->role === 'coach') {
            return !$this->coachProfile || !$this->coachProfile->isComplete();
        }
        return false;
    }
}
