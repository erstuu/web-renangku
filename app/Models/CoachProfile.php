<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'profile_photo',
        'specialization',
        'bio',
        'contact_info',
        'certification',
        'experience_years',
        'hourly_rate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the coach profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if profile is complete for approval
     */
    public function isComplete()
    {
        return !empty($this->specialization) &&
            !empty($this->bio) &&
            !empty($this->contact_info) &&
            !empty($this->certification) &&
            !is_null($this->experience_years);
    }

    /**
     * Get required fields that are missing
     */
    public function getMissingFields()
    {
        $missing = [];

        if (empty($this->specialization)) $missing[] = 'Spesialisasi';
        if (empty($this->bio)) $missing[] = 'Bio/Deskripsi';
        if (empty($this->contact_info)) $missing[] = 'Kontak';
        if (empty($this->certification)) $missing[] = 'Sertifikat';
        if (is_null($this->experience_years)) $missing[] = 'Pengalaman (tahun)';

        return $missing;
    }
}
