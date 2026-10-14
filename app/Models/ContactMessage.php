<?php

namespace App\Models;

use App\Auditable;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use Auditable;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'reply_to',
        'reply_body',
        'replied_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }
}
