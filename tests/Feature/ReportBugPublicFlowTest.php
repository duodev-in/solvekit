<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportBugPublicFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_bug_report_page_uses_the_site_layout_and_accepts_submission(): void
    {
        $response = $this->get(route('report-bug.create'));

        $response->assertOk();
        $response->assertViewIs('report-bug.create');
        $response->assertSee('Report a bug');
        $response->assertSee(route('contact.create'), false);

        $response = $this->from(route('report-bug.create'))->post(route('report-bug.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Temperature result is wrong',
            'description' => 'Converting 100 Celsius shows the wrong Fahrenheit value.',
        ]);

        $response->assertRedirect(route('report-bug.create'));
        $this->assertDatabaseHas('bug_reports', [
            'email' => 'jane@example.com',
            'subject' => 'Temperature result is wrong',
        ]);
    }
}
