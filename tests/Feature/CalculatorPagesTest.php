<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Covers every calculator already moved to the shared Design A frame (<x-calc.page>).
 */
class CalculatorPagesTest extends TestCase
{
    /**
     * @return array<string, array{route: string}>
     */
    private function migratedCalculators(): array
    {
        return collect(config('conversion.calculators'))
            ->filter(function (array $tool) {
                $path = resource_path('views/'.str_replace('.', '/', $tool['view']).'.blade.php');

                return str_contains(file_get_contents($path), '<x-calc.page');
            })
            ->all();
    }

    public function test_migrated_calculators_render_the_shared_frame(): void
    {
        $calculators = $this->migratedCalculators();
        $this->assertNotEmpty($calculators);

        foreach ($calculators as $key => $tool) {
            $html = $this->get(route($tool['route_name']))->assertOk()->getContent();

            $this->assertStringContainsString('data-calc-root', $html, "[{$key}] does not render the calculator frame.");
            $this->assertStringNotContainsString('toolUiRoot', $html, "[{$key}] still uses the old layout.");
            $this->assertStringContainsString('<h1', $html, "[{$key}] has no heading.");
        }
    }

    public function test_each_calculator_names_a_script_module_that_exists(): void
    {
        foreach ($this->migratedCalculators() as $key => $tool) {
            $html = $this->get(route($tool['route_name']))->getContent();

            preg_match('/data-calc="([^"]*)"/', $html, $matches);
            $config = json_decode(html_entity_decode($matches[1] ?? ''), true);
            $engine = $config['engine'] ?? null;

            $this->assertIsString($engine, "[{$key}] has no engine in its calculator config.");
            $this->assertTrue(
                file_exists(resource_path("js/calc/engines/{$engine}.js")) || file_exists(resource_path("js/calc/tools/{$engine}.js")),
                "[{$key}] names module [{$engine}], which does not exist."
            );
        }
    }

    public function test_every_label_points_at_a_control(): void
    {
        foreach ($this->migratedCalculators() as $key => $tool) {
            $html = $this->get(route($tool['route_name']))->getContent();

            preg_match_all('/<label[^>]*\sfor="([^"]+)"/', $html, $labels);
            foreach ($labels[1] as $id) {
                $this->assertMatchesRegularExpression('/\sid="'.preg_quote($id, '/').'"/', $html, "[{$key}] label points at missing #{$id}.");
            }
        }
    }
}
