<?php

namespace App\Services\SuperAdmin;

use App\Mail\ContactMessageReplyMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactMessageService
{
    public function create(array $data): ContactMessage
    {
        return DB::transaction(function () use ($data): ContactMessage {
            return ContactMessage::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'status' => 'new',
                'reply_to' => $data['reply_to'] ?? auth()->user()?->email,
            ]);
        });
    }

    public function reply(ContactMessage $message, array $data): ContactMessage
    {
        return DB::transaction(function () use ($message, $data): ContactMessage {
            $message->update([
                'reply_to' => $data['reply_to'] ?? auth()->user()?->email,
                'reply_body' => $data['reply_body'],
                'replied_by' => auth()->id(),
                'status' => 'replied',
            ]);

            Mail::to($message->email)
                ->replyTo($data['reply_to'] ?? auth()->user()?->email)
                ->send(new ContactMessageReplyMail($message, $data['reply_body']));

            return $message->refresh();
        });
    }
}
