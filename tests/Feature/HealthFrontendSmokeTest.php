<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class HealthFrontendSmokeTest extends TestCase
{
    public function test_health_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('health.index'))->assertOk();

        $response->assertSee('not a diagnosis or treatment advice');

        foreach (config('health.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_health_calculator_page_loads_with_the_information_note(): void
    {
        $this->assertCount(334, config('health.calculators'));

        foreach (config('health.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('For information and education, not a diagnosis or medical advice.');
        }
    }

    public function test_questionnaires_with_a_self_harm_item_carry_crisis_lines(): void
    {
        foreach (['psychiatry-and-psychology::phq-9-depression-calculator', 'psychiatry-and-psychology::epds-calculator'] as $key) {
            $tool = config('health.calculators')[$key];
            $html = $this->get(route($tool['route_name']))->getContent();

            $this->assertStringContainsString('"name":"Health"', $html);
            $this->assertStringContainsString('988', $html);
            $this->assertStringContainsString('Samaritans on 116 123', $html);
            $this->assertStringContainsString('Tele-MANAS on 14416', $html);
        }
    }

    public function test_medicine_dose_calculators_are_not_offered(): void
    {
        $slugs = collect(config('health.calculators'))->pluck('slug');

        foreach (['insulin-dosage-calculator', 'warfarin-dosing-calculator', 'tylenol-dosage-calculator', 'pediatric-dosage-calculator', 'maintenance-fluids-calculator', 'gir-calculator-glucose-infusion-rate'] as $dropped) {
            $this->assertNotContains($dropped, $slugs);
        }

        $this->assertSame(['drug-half-life-calculator', 'fish-oil-calculator', 'mcg-to-iu-converter', 'medicine-3-times-a-day-calculator', 'prescription-refill-calculator'], $slugs->filter(fn (string $slug) => collect(config('health.calculators'))->firstWhere('slug', $slug)['category_slug'] === 'dosage')->sort()->values()->all());
    }

    public function test_links_to_tools_in_other_sections_resolve(): void
    {
        foreach (config('health.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }
}
