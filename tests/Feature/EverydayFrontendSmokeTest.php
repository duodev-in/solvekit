<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EverydayFrontendSmokeTest extends TestCase
{
    public function test_everyday_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('everyday.index'))->assertOk();

        foreach (config('everyday.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_everyday_calculator_page_loads(): void
    {
        $this->assertCount(210, config('everyday.calculators'));

        foreach (config('everyday.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_everyday_pages_live_under_everyday_life(): void
    {
        $tool = config('everyday.calculators')['time-and-date::age-calculator'];

        $this->assertStringEndsWith('/everyday-life/time-and-date/age-calculator', route($tool['route_name']));

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Everyday Life"', $html);
        $this->assertStringContainsString(route('everyday.index').'#time-and-date', $html);
    }

    public function test_links_to_tools_in_other_sections_resolve(): void
    {
        foreach (config('everyday.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }
}
