<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class OtherFrontendSmokeTest extends TestCase
{
    public function test_other_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('other.index'))->assertOk();

        foreach (config('other.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_other_calculator_page_loads_with_its_working_panel(): void
    {
        $this->assertCount(85, config('other.calculators'));
        $this->assertCount(6, config('other.categories'));

        foreach (config('other.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('data-ref="steps"', false);
        }
    }

    public function test_tools_built_elsewhere_are_linked(): void
    {
        foreach (config('other.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }

    public function test_dropped_tools_have_no_page(): void
    {
        $slugs = collect(config('other.calculators'))->pluck('slug');

        foreach (['ap-biology-score-calculator', 'ap-chemistry-score-calculator', 'aquarium-glass-thickness-calculator', 'wingdings-translator', 'white-christmas-calculator'] as $slug) {
            $this->assertNotContains($slug, $slugs);
        }
    }

    public function test_money_tools_offer_the_currency_menu(): void
    {
        foreach (['logistics::landed-cost-calculator', 'miscellaneous::travel-expenses-calculator', 'miscellaneous::streaming-services-royalties-calculator', 'miscellaneous::matched-betting-calculator', 'miscellaneous::gender-pay-gap-calculator'] as $key) {
            $this->get(route(config('other.calculators')[$key]['route_name']))->assertSee('INR', false);
        }
    }

    public function test_reference_data_is_complete(): void
    {
        $data = config('other_data');

        $this->assertCount(13, $data['freight_classes']);
        $this->assertSame([0.5, 1, 1.5, 2, 2.5, 3, 4, 5], $data['dnd_multipliers']);

        foreach (['dim_divisors', 'containers', 'hec', 'ielts', 'pte_ielts', 'rust', 'royalties', 'oxygen', 'dnd_2014', 'dnd_2024', 'dnd_cr_xp', 'med', 'snow_ratio', 'resolutions'] as $table) {
            $this->assertNotEmpty($data[$table], "other_data.{$table} is empty.");
        }
    }

    public function test_other_pages_are_in_the_sitemap(): void
    {
        $sitemap = (string) file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('/other</loc>', $sitemap);

        foreach (config('other.calculators') as $tool) {
            $this->assertStringContainsString('/other/'.$tool['category_slug'].'/'.$tool['slug'].'</loc>', $sitemap);
        }
    }
}
