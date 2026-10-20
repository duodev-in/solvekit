<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PhysicsFrontendSmokeTest extends TestCase
{
    public function test_physics_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('physics.index'))->assertOk();

        foreach (config('physics.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_physics_calculator_page_loads_with_its_working_panel(): void
    {
        $this->assertCount(500, config('physics.calculators'));
        $this->assertCount(19, config('physics.categories'));

        foreach (config('physics.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('data-ref="steps"', false);
        }
    }

    public function test_quiz_pages_became_practice_modes(): void
    {
        $pages = ['dynamics::net-force-calculator', 'energy-work-and-power::potential-energy-calculator', 'rotation-and-oscillation::frequency-calculator', 'materials::bend-allowance-calculator', 'electromagnetism::electrical-power-calculator', 'electromagnetism::power-factor-calculator'];

        foreach ($pages as $key) {
            $this->get(route(config('physics.calculators')[$key]['route_name']))
                ->assertSee('Practice questions')
                ->assertSee('name="question"', false);
        }

        $slugs = collect(config('physics.calculators'))->pluck('slug');

        foreach (['quiz-net-force-calculator', 'quiz-potential-energy-calculator', 'quiz-frequency-calculator', 'quiz-bend-allowance-calculator', 'quiz-electrical-power-calculator', 'quiz-power-factor-calculator'] as $quiz) {
            $this->assertNotContains($quiz, $slugs);
        }
    }

    public function test_tools_built_elsewhere_are_linked_not_copied(): void
    {
        $slugs = collect(config('physics.calculators'))->pluck('slug');

        foreach (config('physics.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }

        foreach (['ideal-gas-law-calculator', 'combined-gas-law-calculator', 'van-der-waals-equation-calculator', 'specific-heat-calculator', 'de-broglie-wavelength-calculator', 'photon-energy-calculator', 'voltage-drop-calculator', 'wire-size-calculator', 'light-year-calculator', 'watt-converter', 'rockwell-hardness-conversion-calculator'] as $slug) {
            $this->assertNotContains($slug, $slugs, "{$slug} should link to its existing page.");
        }

        $this->assertSame(1, $slugs->filter(fn (string $slug) => $slug === 'mass-moment-of-inertia-calculator')->count());
    }

    public function test_dropped_tools_have_no_page(): void
    {
        $slugs = collect(config('physics.calculators'))->pluck('slug');

        foreach (['refrigerant-capillary-tube-calculator', 'magnetic-declination-calculator', 'motor-capacitor-size-calculator'] as $slug) {
            $this->assertNotContains($slug, $slugs);
        }
    }

    public function test_wind_load_is_labelled_as_a_physics_estimate(): void
    {
        $this->get(route(config('physics.calculators')['fluid-mechanics::wind-load-calculator']['route_name']))
            ->assertSee('This is a physics estimate', false)
            ->assertSee('ASCE 7', false);
    }

    public function test_reference_data_is_complete(): void
    {
        $data = config('physics_data');

        foreach (['bodies', 'refractive', 'sound_media', 'solids', 'absorption', 'materials', 'densities', 'gold', 'semiconductors', 'spring_wire', 'cutting', 'conductors', 'dielectrics', 'permeability', 'lamps', 'leds', 'fluids', 'gases', 'latent', 'thermal', 'manning', 'roughness', 'metals', 'work_functions', 'nuclides'] as $table) {
            $this->assertNotEmpty($data[$table] ?? null, "physics_data.{$table} is missing.");

            foreach ($data[$table] as $key => $row) {
                $this->assertNotEmpty($row['name'] ?? null, "physics_data.{$table}.{$key} needs a name.");
            }
        }

        $this->assertEqualsWithDelta(398600.435436, $data['bodies']['earth']['gm'], 1e-6);
        $this->assertEqualsWithDelta(1.7241e-8, $data['conductors']['copper']['rho'], 1e-12);
        $this->assertSame(12, $data['nuclides']['c12']['mass']);
    }

    public function test_physics_pages_are_in_the_sitemap(): void
    {
        $sitemap = (string) file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('/physics</loc>', $sitemap);

        foreach (config('physics.calculators') as $tool) {
            $this->assertStringContainsString('/physics/'.$tool['category_slug'].'/'.$tool['slug'].'</loc>', $sitemap);
        }
    }
}
