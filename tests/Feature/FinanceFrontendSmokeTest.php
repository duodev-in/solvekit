<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FinanceFrontendSmokeTest extends TestCase
{
    public function test_finance_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('finance.index'))->assertOk();

        foreach (config('finance.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_finance_calculator_page_loads(): void
    {
        $this->assertCount(605, config('finance.calculators'));

        foreach (config('finance.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view']);
        }
    }

    public function test_finance_pages_carry_the_planning_disclaimer(): void
    {
        $tool = config('finance.calculators')['mortgage-and-real-estate::mortgage-calculator'];

        $this->assertStringEndsWith('/finance/mortgage-and-real-estate/mortgage-calculator', route($tool['route_name']));

        $html = $this->get(route($tool['route_name']))->getContent();

        $this->assertStringContainsString('"name":"Finance"', $html);
        $this->assertStringContainsString('Estimates for planning, not financial, tax or legal advice.', $html);
    }

    public function test_links_to_tools_in_other_sections_resolve(): void
    {
        foreach (config('finance.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }
}
