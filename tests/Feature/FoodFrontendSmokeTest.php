<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FoodFrontendSmokeTest extends TestCase
{
    public function test_food_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('food.index'))->assertOk();

        foreach (config('food.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_food_calculator_page_loads(): void
    {
        $this->assertCount(78, config('food.calculators'));

        foreach (config('food.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_cooking_time_pages_say_to_use_a_thermometer(): void
    {
        $tool = config('food.calculators')['cooking-converters::air-fryer-calculator'];

        $this->assertStringEndsWith('/food/cooking-converters/air-fryer-calculator', route($tool['route_name']));

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Food and Cooking"', $html);
        $this->assertStringContainsString('check doneness with a food thermometer', $html);
    }

    public function test_links_to_tools_in_other_sections_resolve(): void
    {
        foreach (config('food.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }
}
