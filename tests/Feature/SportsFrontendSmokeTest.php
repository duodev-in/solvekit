<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SportsFrontendSmokeTest extends TestCase
{
    public function test_sports_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('sports.index'))->assertOk();

        foreach (config('sports.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_sports_calculator_page_loads_with_its_working_panel(): void
    {
        $this->assertCount(120, config('sports.calculators'));
        $this->assertCount(12, config('sports.categories'));

        foreach (config('sports.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('data-ref="steps"', false);
        }
    }

    public function test_dunk_calculator_has_a_practice_mode(): void
    {
        $this->get(route(config('sports.calculators')['basketball::dunk-calculator']['route_name']))
            ->assertSee('Practice questions')
            ->assertSee('name="question"', false);
    }

    public function test_money_tools_offer_the_currency_menu(): void
    {
        foreach (['cycling::e-bike-range-calculator', 'cycling::bicycle-lubricant-cost-to-run-calculator', 'other-sports::tennis-ball-usage-calculator'] as $key) {
            $this->get(route(config('sports.calculators')[$key]['route_name']))
                ->assertSee('INR', false);
        }
    }

    public function test_tools_built_elsewhere_are_linked_not_copied(): void
    {
        $slugs = collect(config('sports.calculators'))->pluck('slug');

        foreach (config('sports.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }

        foreach (['calories-burned-calculator', 'steps-to-calories-calculator', 'vo2-max-calculator'] as $slug) {
            $this->assertNotContains($slug, $slugs, "{$slug} should link to its existing page.");
        }
    }

    public function test_dropped_tools_have_no_page(): void
    {
        $slugs = collect(config('sports.calculators'))->pluck('slug');

        foreach (['duckworth-lewis-calculator', 'din-calculator', 'age-grade-calculator', 'swim-time-converter', 'biking-life-gain-calculator', 'bike-tire-pressure-calculator', 'triathlon-time-calculator'] as $slug) {
            $this->assertNotContains($slug, $slugs);
        }
    }

    public function test_reference_data_is_complete(): void
    {
        $data = config('sports_data');

        foreach (['mets', 'wheels'] as $table) {
            foreach ($data[$table] as $key => $row) {
                $this->assertNotEmpty($row['name'] ?? null, "sports_data.{$table}.{$key} needs a name.");
            }
        }

        $this->assertCount(7, $data['combined_events']['heptathlon']);
        $this->assertCount(10, $data['combined_events']['decathlon']);
        $this->assertSame(8.0, $data['mets']['calisthenics_vig']['met']);
        $this->assertCount(4, $data['strength']['ipf_gl']);
    }

    public function test_sports_pages_are_in_the_sitemap(): void
    {
        $sitemap = (string) file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('/sports</loc>', $sitemap);

        foreach (config('sports.calculators') as $tool) {
            $this->assertStringContainsString('/sports/'.$tool['category_slug'].'/'.$tool['slug'].'</loc>', $sitemap);
        }
    }
}
