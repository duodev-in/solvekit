<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UnitTablesTest extends TestCase
{
    public static function exactFactors(): array
    {
        $yard = 0.9144;
        $mile = 1760 * $yard;
        $astronomicalUnit = 149597870700;

        return [
            'inch' => ['length', 'in', 0.0254],
            'foot' => ['length', 'ft', 12 * 0.0254],
            'yard' => ['length', 'yd', $yard],
            'mile' => ['length', 'mi', $mile],
            'nautical mile' => ['length', 'nmi', 1852],
            'decimeter' => ['length', 'dm', 0.1],
            'square foot' => ['area', 'ft2', 0.3048 ** 2],
            'square yard' => ['area', 'yd2', $yard ** 2],
            'acre' => ['area', 'acre', 4840 * $yard ** 2],
            'square mile' => ['area', 'mi2', $mile ** 2],
            'hectare' => ['area', 'ha', 10000],
            'are' => ['area', 'a', 100],
            'astronomical unit' => ['astronomical', 'au', $astronomicalUnit],
            'light year' => ['astronomical', 'ly', 299792458 * 365.25 * 86400],
            'light second' => ['astronomical', 'ls', 299792458],
            'parsec' => ['astronomical', 'pc', 648000 / M_PI * $astronomicalUnit],
            'astronomical mile' => ['astronomical', 'mi', $mile],
        ];
    }

    #[DataProvider('exactFactors')]
    public function test_factor_matches_its_definition(string $table, string $unit, float $expected): void
    {
        $actual = config("units.{$table}.{$unit}.factor");

        $this->assertNotNull($actual, "Unit [{$table}.{$unit}] is missing.");
        $this->assertEqualsWithDelta($expected, $actual, abs($expected) * 1e-12);
    }

    public function test_every_table_has_one_base_unit_and_complete_entries(): void
    {
        foreach (config('units') as $tableName => $units) {
            $baseUnits = array_filter($units, fn (array $unit) => $unit['factor'] == 1);
            $this->assertCount(1, $baseUnits, "Table [{$tableName}] must have exactly one base unit.");

            foreach ($units as $key => $unit) {
                $this->assertNotEmpty($unit['name'] ?? null, "[{$tableName}.{$key}] needs a name.");
                $this->assertNotEmpty($unit['symbol'] ?? null, "[{$tableName}.{$key}] needs a symbol.");
                $this->assertGreaterThan(0, $unit['factor'], "[{$tableName}.{$key}] needs a positive factor.");
            }
        }
    }
}
