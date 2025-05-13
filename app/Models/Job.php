<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'location',
        'type', // full-time, part-time, contract
        'status', // open, closed, draft
        'department',
        'experience_level',
        'salary_range',
        'posted_by',
        'company_id',
        'application_deadline',
        'is_remote',
        'benefits',
        'skills_required',
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'application_deadline' => 'datetime',
        'skills_required' => 'array',
        'benefits' => 'array',
    ];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
