<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MathFrontendSmokeTest extends TestCase
{
    public function test_math_index_lists_every_category_with_tools(): void
    {
        $response = $this->get(route('math.index'))->assertOk();

        foreach (config('math.categories') as $category) {
            $response->assertSee('id="'.$category['slug'].'"', false);

            foreach ($category['tools'] as $tool) {
                $response->assertSee(route($tool['route_name']), false);
            }

            foreach ($category['elsewhere'] ?? [] as $link) {
                $response->assertSee(route($link['route']), false);
            }
        }
    }

    public function test_each_math_calculator_page_loads_with_its_working_panel(): void
    {
        $this->assertCount(601, config('math.calculators'));
        $this->assertCount(16, config('math.categories'));

        foreach (config('math.calculators') as $key => $tool) {
            $this->assertTrue(Route::has($tool['route_name']), "Route for [{$key}] is missing.");

            $this->get(route($tool['route_name']))
                ->assertOk()
                ->assertViewIs($tool['view'])
                ->assertSee('data-ref="steps"', false);
        }
    }

    public function test_synonyms_fold_into_their_main_page(): void
    {
        $pages = [
            'coordinate-geometry::distance-formula-calculator' => 'distance between two points calculator',
            'trigonometry::arcsin-calculator' => 'inverse sine calculator',
            'circles::circumference-calculator' => 'circle perimeter calculator',
            'algebra::complex-number-calculator' => 'imaginary number calculator',
        ];

        foreach ($pages as $key => $synonym) {
            $this->get(route(config('math.calculators')[$key]['route_name']))->assertSee('Also known as', false)->assertSee($synonym, false);
        }
    }

    public function test_quiz_pages_became_practice_modes(): void
    {
        foreach (['2d-geometry::area-of-a-rectangle-calculator', '3d-geometry::right-cylinder-calculator', 'triangles::right-triangle-side-and-angle-calculator', 'trigonometry::trigonometry-calculator'] as $key) {
            $this->get(route(config('math.calculators')[$key]['route_name']))
                ->assertSee('Practice questions')
                ->assertSee('name="question"', false);
        }

        $slugs = collect(config('math.calculators'))->pluck('slug');

        foreach (['quiz-area-of-a-rectangle-calculator', 'quiz-cylinder-volume-calculator', 'quiz-trigonometry-calculator'] as $quiz) {
            $this->assertNotContains($quiz, $slugs);
        }
    }

    public function test_links_to_tools_in_other_sections_resolve(): void
    {
        foreach (config('math.categories') as $category) {
            foreach ($category['elsewhere'] ?? [] as $link) {
                $this->assertTrue(Route::has($link['route']), $link['route']);
            }
        }
    }

    public function test_math_pages_are_in_the_sitemap(): void
    {
        $sitemap = (string) file_get_contents(public_path('sitemap.xml'));

        foreach (config('math.calculators') as $tool) {
            $this->assertStringContainsString('/math/'.$tool['category_slug'].'/'.$tool['slug'].'</loc>', $sitemap);
        }
    }
}
