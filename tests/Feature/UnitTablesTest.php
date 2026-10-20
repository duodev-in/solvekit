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
            'pound' => ['mass', 'lb', 453.59237],
            'ounce' => ['mass', 'oz', 453.59237 / 16],
            'stone' => ['mass', 'st', 14 * 453.59237],
            'US ton' => ['mass', 'ton_us', 2000 * 453.59237],
            'long ton' => ['mass', 'ton_uk', 2240 * 453.59237],
            'microgram' => ['mass', 'ug', 1e-6],
            'US gallon' => ['volume', 'gal_us', 231 * 0.0254 ** 3 * 1000],
            'US quart' => ['volume', 'qt_us', 231 * 0.0254 ** 3 * 1000 / 4],
            'US pint' => ['volume', 'pt_us', 231 * 0.0254 ** 3 * 1000 / 8],
            'US cup' => ['volume', 'cup_us', 231 * 0.0254 ** 3 * 1000 / 16],
            'US fluid ounce' => ['volume', 'floz_us', 231 * 0.0254 ** 3 * 1000 / 128],
            'US tablespoon' => ['volume', 'tbsp_us', 231 * 0.0254 ** 3 * 1000 / 256],
            'US teaspoon' => ['volume', 'tsp_us', 231 * 0.0254 ** 3 * 1000 / 768],
            'imperial gallon' => ['volume', 'gal_uk', 4.54609],
            'imperial pint' => ['volume', 'pt_uk', 4.54609 / 8],
            'imperial fluid ounce' => ['volume', 'floz_uk', 4.54609 / 160],
            'cubic foot' => ['volume', 'ft3', 0.3048 ** 3 * 1000],
            'cubic yard' => ['volume', 'yd3', $yard ** 3 * 1000],
            'cubic inch' => ['volume', 'in3', 0.0254 ** 3 * 1000],
            'CCF' => ['volume', 'ccf', 100 * 0.3048 ** 3 * 1000],
            'psi' => ['pressure', 'psi', 0.45359237 * 9.80665 / 0.0254 ** 2],
            'torr' => ['pressure', 'torr', 101325 / 760],
            'bar' => ['pressure', 'bar', 100000],
            'inch of water' => ['pressure', 'inh2o', 25.4 * 9.80665],
            'pound-force' => ['force', 'lbf', 0.45359237 * 9.80665],
            'kip' => ['force', 'kip', 1000 * 0.45359237 * 9.80665],
            'poundal' => ['force', 'pdl', 0.45359237 * 0.3048],
            'foot-pound torque' => ['torque', 'lbfft', 0.45359237 * 9.80665 * 0.3048],
            'inch-pound torque' => ['torque', 'lbfin', 0.45359237 * 9.80665 * 0.0254],
            'mile per hour' => ['speed', 'mph', 1609.344 / 3600],
            'knot' => ['speed', 'knot', 1852 / 3600],
            'kilometer per hour' => ['speed', 'kmh', 1000 / 3600],
            'mile per US gallon' => ['fuel_economy', 'mpg_us', 1.609344 / 3.785411784],
            'kilowatt-hour' => ['energy', 'kwh', 3.6e6],
            'thermochemical calorie' => ['energy', 'cal', 4.184],
            'IT BTU' => ['energy', 'btu', 1055.05585262],
            'electronvolt' => ['energy', 'ev', 1.602176634e-19],
            'ton of TNT' => ['energy', 'tnt', 4.184e9],
            'mechanical horsepower' => ['power', 'hp', 550 * 0.45359237 * 9.80665 * 0.3048],
            'metric horsepower' => ['power', 'ps', 75 * 9.80665],
            'ton of refrigeration' => ['power', 'tr', 12000 * 1055.05585262 / 3600],
            'ampere-hour' => ['charge', 'ah', 3600],
            'degree' => ['angle', 'deg', M_PI / 180],
            'NATO mil' => ['angle', 'mil', 2 * M_PI / 6400],
            'grain' => ['mass', 'gr', 0.06479891],
            'gigapascal' => ['pressure', 'gpa', 1e9],
            'megaparsec' => ['astronomical', 'mpc', 1e6 * 648000 / M_PI * $astronomicalUnit],
            'standard gravity' => ['acceleration', 'g0', 9.80665],
            'revolution per minute' => ['angular_speed', 'rpm', 2 * M_PI / 60],
            'pound-force per inch' => ['stiffness', 'lbfpin', 0.45359237 * 9.80665 / 0.0254],
            'solar mass (IAU GM☉ ÷ G)' => ['astro_mass', 'msun', 1.32712440018e20 / 6.6743e-11],
            'atomic mass unit' => ['particle_mass', 'u', 1.66053906660e-27],
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
            // A table may hold several quantities (each unit names its `base`); each needs one base unit.
            // An `alias` is the same unit under another name (a 1 °C step is 1 K) and is not a second base.
            $quantities = collect($units)->groupBy(fn (array $unit) => $unit['base'] ?? $tableName);
            foreach ($quantities as $quantity => $quantityUnits) {
                $baseUnits = $quantityUnits->filter(fn (array $unit) => $unit['factor'] == 1 && empty($unit['inverse']) && empty($unit['offset']) && empty($unit['alias']));
                $this->assertCount(1, $baseUnits, "[{$tableName}] quantity [{$quantity}] must have exactly one base unit.");
            }

            foreach ($units as $key => $unit) {
                $this->assertNotEmpty($unit['name'] ?? null, "[{$tableName}.{$key}] needs a name.");
                $this->assertIsString($unit['symbol'] ?? null, "[{$tableName}.{$key}] needs a symbol (empty only for plain counts).");
                // Reversed scales such as Delisle have a negative factor; zero is never valid.
                $this->assertNotEquals(0, $unit['factor'], "[{$tableName}.{$key}] needs a non-zero factor.");
            }
        }
    }

    public function test_substance_densities_are_positive_and_named(): void
    {
        foreach (config('substances') as $groupKey => $group) {
            $this->assertNotEmpty($group['label'], "Substance group [{$groupKey}] needs a label.");

            foreach ($group['items'] as $key => $item) {
                $this->assertNotEmpty($item['name'], "Substance [{$key}] needs a name.");
                $this->assertGreaterThan(0, $item['density'], "Substance [{$key}] needs a positive density.");
                $this->assertLessThan(25, $item['density'], "Substance [{$key}] density should be in g/mL.");
            }
        }
    }
}
