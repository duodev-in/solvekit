<?php

namespace Tests\Feature;

use App\Models\FeatureRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureRequestPublicFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_feature_request_page_loads_and_accepts_submission(): void
    {
        $response = $this->get(route('feature-request.create'));

        $response->assertOk();
        $response->assertSee('Request a feature');

        $response = $this->post(route('feature-request.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'title' => 'Dark mode for conversion tools',
            'description' => 'It would help to have a dark mode for the calculator pages.',
            'category' => 'UI',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('feature_requests', [
            'email' => 'jane@example.com',
            'title' => 'Dark mode for conversion tools',
            'status' => 'submitted',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'created',
            'auditable_type' => FeatureRequest::class,
        ]);
    }
}
