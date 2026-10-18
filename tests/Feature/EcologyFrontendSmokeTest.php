<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EcologyFrontendSmokeTest extends TestCase
{
    public function test_ecology_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('ecology.index'))->assertOk();

        foreach (config('ecology.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }
        }
    }

    public function test_each_ecology_calculator_page_loads(): void
    {
        $this->assertCount(42, config('ecology.calculators'));

        foreach (config('ecology.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_ecology_pages_use_their_own_breadcrumb_and_related_tools(): void
    {
        $tool = config('ecology.calculators')['eco-footprint::flight-carbon-footprint-calculator'];

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Ecology"', $html);
        $this->assertStringContainsString(route('ecology.index').'#eco-footprint', $html);
        $this->assertStringContainsString('id="airport-list"', $html);
    }

    public function test_biology_ecology_tools_moved_here(): void
    {
        foreach (['shannon-diversity-index-calculator', 'simpson-diversity-index-calculator', 'population-growth-calculator', 'mark-recapture-calculator'] as $slug) {
            $this->assertFalse(Route::has("biology.ecology.{$slug}"), $slug);
            $this->get(route("ecology.other.{$slug}"))->assertOk();
        }

        $this->assertCount(120, config('biology.calculators'));
    }

    public function test_no_calculator_is_listed_in_two_sections(): void
    {
        $slugs = collect(['conversion', 'biology', 'chemistry', 'construction', 'ecology'])
            ->flatMap(fn (string $section) => collect(config("{$section}.calculators"))->pluck('slug'));

        $this->assertSame($slugs->count(), $slugs->unique()->count(), 'Duplicate tools: '.$slugs->duplicates()->implode(', '));
    }

    public function test_airport_list_is_published(): void
    {
        $data = json_decode((string) file_get_contents(public_path('data/airports.json')), true);

        $this->assertGreaterThan(3000, count($data['airports']));
        $this->assertContains('LHR', array_column($data['airports'], 0));
    }
}
