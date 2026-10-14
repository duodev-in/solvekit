<?php

namespace App\Services\SuperAdmin;

use App\Models\FeatureRequest;
use Illuminate\Support\Facades\DB;

class FeatureRequestService
{
    public function create(array $data): FeatureRequest
    {
        return DB::transaction(function () use ($data): FeatureRequest {
            return FeatureRequest::create([
                'user_id' => $data['user_id'] ?? null,
                'name' => $data['name'],
                'email' => $data['email'],
                'title' => $data['title'],
                'description' => $data['description'],
                'category' => $data['category'],
                'status' => $data['status'] ?? 'submitted',
            ]);
        });
    }

    public function updateStatus(FeatureRequest $featureRequest, array $data): FeatureRequest
    {
        return DB::transaction(function () use ($featureRequest, $data): FeatureRequest {
            $featureRequest->update([
                'status' => $data['status'] ?? $featureRequest->status,
                'admin_notes' => $data['admin_notes'] ?? $featureRequest->admin_notes,
            ]);

            return $featureRequest->refresh();
        });
    }
}
