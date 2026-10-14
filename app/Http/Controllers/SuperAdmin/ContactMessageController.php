<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\SuperAdmin\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function __construct(private ContactMessageService $contactMessageService) {}

    public function index(Request $request): View
    {
        abort_unless(auth()->user()->can('view contact messages'), 403);

        return view('superadmin.contact-messages.index', [
            'messages' => ContactMessage::query()
                ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
                ->latest()
                ->paginate(20)
                ->withQueryString(),
        ]);
    }

    public function update(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        abort_unless(auth()->user()->can('reply to contact messages'), 403);

        $data = $request->validate([
            'reply_to' => ['required', 'email'],
            'reply_body' => ['required', 'string', 'min:10', 'max:10000'],
        ]);

        $this->contactMessageService->reply($contactMessage, $data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Reply sent successfully.']);
    }
}
