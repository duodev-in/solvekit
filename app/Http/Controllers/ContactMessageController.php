<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Services\SuperAdmin\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function __construct(private ContactMessageService $contactMessageService) {}

    public function create(): View
    {
        return view('contact.create');
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $this->contactMessageService->create($request->validated());

        return redirect()->route('contact.create')->with('toast', ['type' => 'success', 'message' => 'Your message has been sent. We will get back to you soon.']);
    }
}
