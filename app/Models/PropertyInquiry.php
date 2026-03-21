<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyInquiry extends Model
{
    protected $fillable = [
        'property_id',
        'type',
        'name',
        'email',
        'phone',
        'message',
        'tour_date',
        'tour_time',
        'tour_type',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'tour_date' => 'date',
            'is_read' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
