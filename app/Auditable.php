<?php

namespace App;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        static::created(function (Model $model) {
            $model->writeAuditLog('created');
        });

        static::updated(function (Model $model) {
            $model->writeAuditLog('updated', $model->getOriginal(), $model->getAttributes());
        });

        static::deleted(function (Model $model) {
            $model->writeAuditLog('deleted');
        });
    }

    protected function writeAuditLog(string $event, array $oldValues = [], array $newValues = []): void
    {
        if ($this instanceof AuditLog) {
            return;
        }

        AuditLog::create([
            'auditable_type' => $this::class,
            'auditable_id' => $this->getKey(),
            'event' => $event,
            'user_id' => Auth::id(),
            'old_values' => $this->withoutHiddenAttributes($oldValues),
            'new_values' => $this->withoutHiddenAttributes($newValues ?: $this->getAttributes()),
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }

    /**
     * Strip attributes the model hides from serialization (e.g. password hashes) before they are logged.
     */
    protected function withoutHiddenAttributes(array $values): array
    {
        return array_diff_key($values, array_flip($this->getHidden()));
    }
}
