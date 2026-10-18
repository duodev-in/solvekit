<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ConstructionFrontendSmokeTest extends TestCase
{
    public function test_construction_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('construction.index'))->assertOk();

        foreach (config('construction.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }
        }
    }

    public function test_each_construction_calculator_page_loads(): void
    {
        $this->assertCount(135, config('construction.calculators'));

        foreach (config('construction.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_construction_pages_use_their_own_breadcrumb_and_related_tools(): void
    {
        $tool = config('construction.calculators')['construction-materials::gravel-calculator'];

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Construction"', $html);
        $this->assertStringContainsString(route('construction.index').'#construction-materials', $html);
        $this->assertStringContainsString(route('construction.construction-materials.aluminum-weight-calculator'), $html);
    }

    public function test_board_foot_calculator_moved_from_biology(): void
    {
        $this->assertFalse(Route::has('biology.trees-and-forestry.board-feet-calculator'));
        $this->get(route('construction.construction-converters.board-foot-calculator'))->assertOk()->assertSee('Doyle');
    }

    public function test_no_calculator_is_listed_in_two_sections(): void
    {
        $slugs = collect(['conversion', 'biology', 'chemistry', 'construction'])
            ->flatMap(fn (string $section) => collect(config("{$section}.calculators"))->pluck('slug'));

        $this->assertSame($slugs->count(), $slugs->unique()->count(), 'Duplicate tools: '.$slugs->duplicates()->implode(', '));
    }

    public function test_navbar_links_to_the_construction_section(): void
    {
        $this->get(route('construction.index'))->assertSee(route('construction.index'), false)->assertSee('Construction');
    }
}
