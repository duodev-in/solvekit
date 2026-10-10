<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBugReportRequest;
use App\Services\SuperAdmin\ReportBugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportBugController extends Controller
{
    public function __construct(private ReportBugService $reportBugService) {}

    public function create(): View
    {
        return view('report-bug.create');
    }

    public function store(StoreBugReportRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()?->id;
        $this->reportBugService->create($data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Thank you. Your bug report was sent to the development team.']);
    }
}
