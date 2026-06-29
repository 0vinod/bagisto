<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'mobile',
        'notes',
        'rating',
        'is_responded',
        'responded_at',
        'admin_response'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_responded' => 'boolean',
        'responded_at' => 'datetime',
    ];

    // Accessor for rating label
    public function getRatingLabelAttribute(): string
    {
        $labels = [
            1 => 'Poor',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Very Good',
            5 => 'Excellent'
        ];
        return $labels[$this->rating] ?? 'Not Rated';
    }

    // Scope for high ratings
    public function scopeHighRated($query)
    {
        return $query->where('rating', '>=', 4);
    }

    // Scope for low ratings
    public function scopeLowRated($query)
    {
        return $query->where('rating', '<=', 2);
    }
}