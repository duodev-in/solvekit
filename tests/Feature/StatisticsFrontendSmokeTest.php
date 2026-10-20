<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class StatisticsFrontendSmokeTest extends TestCase
{
    public function test_statistics_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('statistics.index'))->assertOk();

        foreach (config('statistics.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_statistics_calculator_page_loads_with_its_working_panel(): void
    {
        $this->assertCount(168, config('statistics.calculators'));
        $this->assertCount(5, config('statistics.categories'));

        foreach (config('statistics.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('data-ref="steps"', false)
                ->assertDontSee('unit menu');
        }
    }

    public function test_quiz_pages_became_practice_modes(): void
    {
        foreach (['probability-and-odds::dice-average-calculator', 'probability-and-odds::lottery-calculator'] as $key) {
            $this->get(route(config('statistics.calculators')[$key]['route_name']))
                ->assertSee('Practice questions')
                ->assertSee('name="question"', false);
        }

        $this->get(route('ecology.other.simpson-diversity-index-calculator'))
            ->assertSee('Practice questions')
            ->assertSee('name="question"', false);

        $slugs = collect(config('statistics.calculators'))->pluck('slug');

        foreach (['quiz-dice-average-calculator', 'quiz-lottery-calculator', 'quiz-simpsons-diversity-index-calculator'] as $quiz) {
            $this->assertNotContains($quiz, $slugs);
        }
    }

    public function test_tools_built_elsewhere_are_linked_not_copied(): void
    {
        $slugs = collect(config('statistics.calculators'))->pluck('slug');

        foreach (config('statistics.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }

        foreach (['combination-calculator', 'permutation-calculator', 'random-number-generator', 'simpsons-diversity-index-calculator', 'relative-error-calculator'] as $slug) {
            $this->assertNotContains($slug, $slugs, "{$slug} should link to its existing page.");
        }
    }

    public function test_dropped_tools_have_no_page(): void
    {
        $this->assertNotContains('smpx-distribution-calculator', collect(config('statistics.calculators'))->pluck('slug'));
    }

    public function test_money_tools_offer_the_currency_menu(): void
    {
        foreach (['probability-and-odds::lottery-calculator', 'probability-and-odds::roulette-payout-calculator', 'probability-and-odds::kelly-criterion-calculator', 'probability-and-odds::odds-calculator'] as $key) {
            $this->get(route(config('statistics.calculators')[$key]['route_name']))
                ->assertSee('INR', false);
        }
    }

    public function test_reference_data_is_complete(): void
    {
        $data = config('statistics_data');

        $this->assertSame(range(2, 25), array_keys($data['control_charts']));
        $this->assertEqualsWithDelta(0.5768, $data['control_charts'][5]['A2'], 1e-4);
        $this->assertEqualsWithDelta(2.1145, $data['control_charts'][5]['D4'], 1e-4);

        foreach ($data['lotteries'] as $key => $lottery) {
            $this->assertNotEmpty($lottery['name'], "statistics_data.lotteries.{$key} needs a name.");
            $this->assertNotEmpty($lottery['source'], "statistics_data.lotteries.{$key} needs a source.");
        }

        $this->assertCount(4, $data['benford_mad']);
    }

    public function test_statistics_pages_are_in_the_sitemap(): void
    {
        $sitemap = (string) file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('/statistics</loc>', $sitemap);

        foreach (config('statistics.calculators') as $tool) {
            $this->assertStringContainsString('/statistics/'.$tool['category_slug'].'/'.$tool['slug'].'</loc>', $sitemap);
        }
    }
}
