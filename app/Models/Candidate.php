<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume_path',
        'cover_letter',
        'current_company',
        'current_position',
        'experience_years',
        'education',
        'skills',
        'linkedin_url',
        'portfolio_url',
        'source', // where the candidate came from
        'status', // new, screening, interview, offer, hired, rejected
        'notes',
        'job_id',
        'applied_at',
    ];

    protected $casts = [
        'skills' => 'array',
        'education' => 'array',
        'applied_at' => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'candidate_job')
            ->withPivot(['stage', 'notes'])
            ->withTimestamps();
    }
}
