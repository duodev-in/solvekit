<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BugReport;
use App\Services\SuperAdmin\ReportBugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportBugController extends Controller
{
    public function __construct(private ReportBugService $reportBugService) {}

    public function index(Request $request): View
    {
        abort_unless(auth()->user()->can('view bug reports'), 403);

        return view('superadmin.bug-reports.index', [
            'reports' => BugReport::query()
                ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
                ->latest()
                ->paginate(20)
                ->withQueryString(),
        ]);
    }

    public function update(Request $request, BugReport $reportBug): RedirectResponse
    {
        abort_unless(auth()->user()->can('manage bug reports'), 403);
        $data = $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved,closed'],
            'admin_notes' => ['nullable', 'string', 'max:10000'],
        ]);
        $this->reportBugService->updateStatus($reportBug, $data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Bug report updated.']);
    }
}
