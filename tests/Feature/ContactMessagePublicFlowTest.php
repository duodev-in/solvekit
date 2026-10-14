<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessagePublicFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_contact_page_loads_and_accepts_submission(): void
    {
        $response = $this->get(route('contact.create'));

        $response->assertOk();
        $response->assertSee('Contact us');

        $response = $this->post(route('contact.store'), [
            'name' => 'Jane Contact',
            'email' => 'contact@example.com',
            'subject' => 'Need help with pricing',
            'message' => 'We want to know how a custom plan would work for our team.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'contact@example.com',
            'subject' => 'Need help with pricing',
            'status' => 'new',
        ]);
    }
}
