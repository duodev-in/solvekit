<?php

namespace App\Models;

use App\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureRequest extends Model
{
    use Auditable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'title',
        'description',
        'category',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
