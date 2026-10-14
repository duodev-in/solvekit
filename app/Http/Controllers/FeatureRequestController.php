<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeatureRequestRequest;
use App\Services\SuperAdmin\FeatureRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeatureRequestController extends Controller
{
    public function __construct(private FeatureRequestService $featureRequestService) {}

    public function create(): View
    {
        return view('feature-requests.create');
    }

    public function store(StoreFeatureRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()?->id;

        $this->featureRequestService->create($data);

        return redirect()->route('feature-request.create')->with('toast', ['type' => 'success', 'message' => 'Thanks for sharing that idea. The product team will review it shortly.']);
    }
}
