<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FeatureRequest;
use App\Services\SuperAdmin\FeatureRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeatureRequestController extends Controller
{
    public function __construct(private FeatureRequestService $featureRequestService) {}

    public function index(): View
    {
        abort_unless(auth()->user()->can('view feature requests'), 403);

        return view('superadmin.feature-requests.index', [
            'featureRequests' => FeatureRequest::with('user')->orderByDesc('created_at')->get(),
        ]);
    }

    public function update(Request $request, FeatureRequest $featureRequest): RedirectResponse
    {
        abort_unless(auth()->user()->can('manage feature requests'), 403);

        $data = $request->validate([
            'status' => ['required', 'string', 'in:submitted,reviewing,planned,in_progress,completed,rejected'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $this->featureRequestService->updateStatus($featureRequest, $data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Feature request updated.']);
    }
}
