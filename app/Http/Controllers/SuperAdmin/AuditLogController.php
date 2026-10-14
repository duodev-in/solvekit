<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\BugReport;
use App\Models\ContactMessage;
use App\Models\FeatureRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('view audit logs'), 403);

        $auditLogs = AuditLog::query()
            ->with('user')
            ->when($request->filled('event'), fn ($query) => $query->where('event', $request->string('event')))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('superadmin.audit-logs.index', [
            'auditLogs' => $auditLogs,
            'events' => AuditLog::query()->distinct()->orderBy('event')->pluck('event'),
        ]);
    }

    public function show(Request $request, AuditLog $auditLog): View
    {
        abort_unless($request->user()->can('view audit logs'), 403);

        $auditLog->load(['user', 'auditable']);
        $oldValues = $auditLog->old_values ?? [];
        $newValues = $auditLog->new_values ?? [];
        $fields = collect(array_unique(array_merge(array_keys($oldValues), array_keys($newValues))))
            ->sort()
            ->map(fn (string $field): array => [
                'field' => $field,
                'old' => $oldValues[$field] ?? null,
                'new' => $newValues[$field] ?? null,
            ]);

        return view('superadmin.audit-logs.show', [
            'auditLog' => $auditLog,
            'changes' => $fields,
            'recordUrl' => $this->recordUrl($auditLog),
        ]);
    }

    private function recordUrl(AuditLog $auditLog): ?string
    {
        return match ($auditLog->auditable_type) {
            User::class => route('admin.users.show', $auditLog->auditable_id),
            BugReport::class => route('admin.bug-reports.index'),
            FeatureRequest::class => route('admin.feature-requests.index'),
            ContactMessage::class => route('admin.contact-messages.index'),
            default => null,
        };
    }
}
