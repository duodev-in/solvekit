<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class BiologyFrontendSmokeTest extends TestCase
{
    public function test_biology_index_lists_every_category_and_tool(): void
    {
        $response = $this->get(route('biology.index'))->assertOk();

        foreach (config('biology.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }
        }
    }

    public function test_each_biology_calculator_page_loads(): void
    {
        foreach (config('biology.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_biology_pages_use_their_own_breadcrumb_and_related_tools(): void
    {
        $tool = config('biology.calculators')['gardening-and-crops::mulch-calculator'];

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Biology & Nature"', $html);
        $this->assertStringContainsString(route('biology.index').'#gardening-and-crops', $html);
        $this->assertStringContainsString(route('biology.gardening-and-crops.soil-calculator'), $html);
    }

    public function test_reference_data_is_complete_and_positive(): void
    {
        foreach (config('biology_data') as $set => $items) {
            foreach ($items as $key => $item) {
                $this->assertNotEmpty($item['name'] ?? null, "[{$set}.{$key}] needs a name.");

                foreach ($item as $field => $value) {
                    if (is_numeric($value)) {
                        $this->assertGreaterThan(0, $value, "[{$set}.{$key}.{$field}] must be positive.");
                    }
                }
            }
        }
    }
}
