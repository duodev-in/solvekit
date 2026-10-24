<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TechnologyFrontendSmokeTest extends TestCase
{
    public function test_technology_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('technology.index'))->assertOk();

        foreach (config('technology.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_technology_calculator_page_loads_with_its_working_panel(): void
    {
        $this->assertCount(113, config('technology.calculators'));
        $this->assertCount(4, config('technology.categories'));

        foreach (config('technology.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('data-ref="steps"', false);
        }
    }

    public function test_tools_built_elsewhere_are_linked(): void
    {
        foreach (config('technology.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }

    public function test_money_tools_offer_the_currency_menu(): void
    {
        $this->get(route('technology.tech-and-electronics.3d-printing-cost-calculator'))->assertSee('INR', false);
    }

    public function test_reference_data_is_complete(): void
    {
        $data = config('technology_data');

        foreach (['sensors', 'film', 'youtube', 'strings'] as $table) {
            $this->assertNotEmpty($data[$table], "technology_data.{$table} is empty.");
        }
    }

    public function test_technology_pages_are_in_the_sitemap(): void
    {
        $sitemap = (string) file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('/technology</loc>', $sitemap);

        foreach (config('technology.calculators') as $tool) {
            $this->assertStringContainsString('/technology/'.$tool['category_slug'].'/'.$tool['slug'].'</loc>', $sitemap);
        }
    }
}
