<?php

namespace Tests\Feature;

use Tests\TestCase;

class ElementsDataTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    private function elements(): array
    {
        return config('elements');
    }

    public function test_all_118_elements_are_listed_in_order(): void
    {
        $elements = array_values($this->elements());

        $this->assertCount(118, $elements);

        foreach ($elements as $index => $element) {
            $this->assertSame($index + 1, $element['z']);
        }
    }

    public function test_atomic_weights_match_iupac_abridged_values(): void
    {
        $expected = ['H' => 1.008, 'C' => 12.011, 'N' => 14.007, 'O' => 15.999, 'Na' => 22.990, 'S' => 32.06, 'Cl' => 35.45, 'Fe' => 55.845, 'Cu' => 63.546, 'Ag' => 107.87, 'Au' => 196.97, 'U' => 238.03];

        foreach ($expected as $symbol => $weight) {
            $this->assertEqualsWithDelta($weight, $this->elements()[$symbol]['weight'], 1e-9, $symbol);
        }
    }

    public function test_electron_configurations_hold_z_electrons(): void
    {
        $elements = $this->elements();

        foreach ($elements as $symbol => $element) {
            preg_match('/^(?:\[(\w+)\]\s*)?(.*)$/', $element['configuration'], $parts);
            $electrons = $parts[1] !== '' ? $elements[$parts[1]]['z'] : 0;

            foreach (preg_split('/\s+/', trim($parts[2])) as $subshell) {
                $this->assertMatchesRegularExpression('/^\d[spdf]\d+$/', $subshell, $symbol);
                $electrons += (int) substr($subshell, 2);
            }

            $this->assertSame($element['z'], $electrons, $symbol);
        }
    }

    public function test_known_exceptions_to_the_aufbau_order(): void
    {
        $expected = ['Cr' => '[Ar] 3d5 4s1', 'Cu' => '[Ar] 3d10 4s1', 'Pd' => '[Kr] 4d10', 'Pt' => '[Xe] 4f14 5d9 6s1', 'Gd' => '[Xe] 4f7 5d1 6s2', 'Lr' => '[Rn] 5f14 7s2 7p1'];

        foreach ($expected as $symbol => $configuration) {
            $this->assertSame($configuration, $this->elements()[$symbol]['configuration'], $symbol);
        }
    }

    public function test_isotope_abundances_add_up_and_match_the_atomic_weight(): void
    {
        foreach ($this->elements() as $symbol => $element) {
            if ($element['isotopes'] === []) {
                continue;
            }

            $abundance = array_sum(array_column($element['isotopes'], 2));
            $average = array_sum(array_map(fn (array $isotope) => $isotope[1] * $isotope[2], $element['isotopes'])) / $abundance;

            $this->assertEqualsWithDelta(1, $abundance, 0.002, "{$symbol} abundances");
            $this->assertEqualsWithDelta($element['weight'], $average, max(2 * ($element['uncertainty'] ?? 0), 0.01), "{$symbol} average mass");
        }
    }

    public function test_pauling_electronegativity_and_ionization_energy(): void
    {
        $elements = $this->elements();

        $this->assertSame(3.98, $elements['F']['electronegativity']);
        $this->assertSame(3.44, $elements['O']['electronegativity']);
        $this->assertSame(0.79, $elements['Cs']['electronegativity']);
        $this->assertEqualsWithDelta(13.598, $elements['H']['ionization_energy'], 1e-3);
        $this->assertEqualsWithDelta(5.139, $elements['Na']['ionization_energy'], 1e-3);
    }

    public function test_periodic_table_layout(): void
    {
        $elements = $this->elements();

        $this->assertSame([1, 1, 's'], [$elements['Na']['period'] - 2, $elements['Na']['group'], $elements['Na']['block']]);
        $this->assertSame([4, 8, 'd'], [$elements['Fe']['period'], $elements['Fe']['group'], $elements['Fe']['block']]);
        $this->assertSame([6, 17, 'p'], [$elements['At']['period'], $elements['At']['group'], $elements['At']['block']]);
        $this->assertSame([3, 'd'], [$elements['Lu']['group'], $elements['Lu']['block']]);
        $this->assertNull($elements['Ce']['group']);
        $this->assertSame(18, $elements['Og']['group']);
    }
}
