<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ConversionFrontendSmokeTest extends TestCase
{
    public function test_home_page_loads_successfully(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_conversion_index_page_loads_successfully(): void
    {
        $response = $this->get(route('conversion.index'));

        $response->assertOk();
        $response->assertSeeText('Precision Conversion Tools');

        foreach (config('conversion.categories', []) as $category) {
            if (is_array($category) && ! empty($category['title']) && is_string($category['title'])) {
                $response->assertSeeText($category['title']);
            }
        }
    }

    public function test_each_conversion_calculator_page_loads_successfully(): void
    {
        $categories = config('conversion.categories', []);

        $this->assertNotEmpty($categories, 'Conversion categories config must not be empty.');

        foreach ($categories as $category) {
            $tools = $category['tools'] ?? [];
            $this->assertIsArray($tools, 'Each conversion category must have a tools array.');

            foreach ($tools as $tool) {
                $routeName = $tool['route_name'] ?? null;
                $viewName = $tool['view'] ?? null;

                $this->assertIsString($routeName, 'Each calculator tool must include a route_name string.');
                $this->assertNotSame('', trim($routeName), 'Calculator route_name cannot be empty.');
                $this->assertTrue(Route::has($routeName), "Route [{$routeName}] is not registered.");

                $response = $this->get(route($routeName));
                $response->assertOk();

                if (is_string($viewName) && $viewName !== '') {
                    $response->assertViewIs($viewName);
                }
            }
        }
    }

    public function test_conversion_index_contains_links_for_all_configured_calculators(): void
    {
        $response = $this->get(route('conversion.index'));
        $response->assertOk();

        $categories = config('conversion.categories', []);
        $this->assertNotEmpty($categories, 'Conversion categories config must not be empty.');

        foreach ($categories as $category) {
            $tools = $category['tools'] ?? [];

            foreach ($tools as $tool) {
                $routeName = $tool['route_name'] ?? null;

                $this->assertIsString($routeName, 'Each calculator tool must include a route_name string.');
                $this->assertNotSame('', trim($routeName), 'Calculator route_name cannot be empty.');

                $response->assertSee(route($routeName), false);
            }
        }
    }
}