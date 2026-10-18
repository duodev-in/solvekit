<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ChemistryFrontendSmokeTest extends TestCase
{
    public function test_chemistry_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('chemistry.index'))->assertOk();

        foreach (config('chemistry.categories') as $category) {
            if ($category['tools'] === []) {
                $response->assertDontSee('id="'.$category['slug'].'"', false);

                continue;
            }

            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }
        }
    }

    public function test_each_chemistry_calculator_page_loads(): void
    {
        foreach (config('chemistry.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_chemistry_pages_use_their_own_breadcrumb_and_related_tools(): void
    {
        $tool = config('chemistry.calculators')['mixtures-and-solutions::solution-dilution-calculator'];

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Chemistry"', $html);
        $this->assertStringContainsString(route('chemistry.index').'#mixtures-and-solutions', $html);
        $this->assertStringContainsString(route('chemistry.mixtures-and-solutions.serial-dilution-calculator'), $html);
    }

    public function test_no_calculator_is_listed_in_two_sections(): void
    {
        $slugs = collect(['conversion', 'biology', 'chemistry', 'construction'])
            ->flatMap(fn (string $section) => collect(config("{$section}.calculators"))->pluck('slug'));

        $this->assertSame($slugs->count(), $slugs->unique()->count(), 'Duplicate tools: '.$slugs->duplicates()->implode(', '));
    }

    public function test_reference_data_is_named_and_positive(): void
    {
        foreach (config('chemistry_data') as $set => $items) {
            foreach ($items as $key => $item) {
                $this->assertNotEmpty($item['name'] ?? null, "[{$set}.{$key}] needs a name.");
            }
        }

        foreach (config('chemistry_data.buffers') as $key => $buffer) {
            $this->assertGreaterThan(0, $buffer['pka'], "[buffers.{$key}] needs a pKa.");
        }
    }
}
