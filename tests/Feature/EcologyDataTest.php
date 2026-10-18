<?php

namespace Tests\Feature;

use Tests\TestCase;

class EcologyDataTest extends TestCase
{
    public function test_flight_factors_include_radiative_forcing_and_rank_by_cabin(): void
    {
        foreach (config('ecology_data.flights') as $haul => $classes) {
            foreach ($classes as $cabin => $factor) {
                // DESNZ applies a 1.7 multiplier to the CO2 part for radiative forcing.
                $this->assertGreaterThan($factor['without_rf'], $factor['with_rf'], "{$haul} {$cabin}");
            }
        }

        $long = config('ecology_data.flights.long');
        $this->assertLessThan($long['business']['with_rf'], $long['economy']['with_rf']);
        $this->assertLessThan($long['first']['with_rf'], $long['business']['with_rf']);
        $this->assertSame(0.11704, $long['economy']['with_rf']);
    }

    public function test_grid_intensity_is_plausible_for_every_country(): void
    {
        $grid = config('ecology_data.grid');

        $this->assertGreaterThan(200, count($grid));

        foreach ($grid as $code => $row) {
            $this->assertNotEmpty($row['name'], $code);
            $this->assertGreaterThanOrEqual(0, $row['g'], $code);
            $this->assertLessThan(1500, $row['g'], $code);
        }

        $this->assertLessThan($grid['IND']['g'], $grid['FRA']['g']);
    }

    public function test_food_and_diet_tables(): void
    {
        $food = config('ecology_data.food');

        $this->assertCount(38, $food);
        $this->assertGreaterThan($food['poultry_meat']['ghg'] * 5, $food['beef_beef_herd']['ghg']);

        $diets = array_column(config('ecology_data.diets'), 'ghg');
        $sorted = $diets;
        rsort($sorted);
        $this->assertSame($sorted, $diets, 'Diets are listed from highest to lowest footprint.');
    }

    public function test_bag_break_even_uses_grow_with_plastic_reuse(): void
    {
        foreach (config('ecology_data.bags') as $key => $bag) {
            $this->assertSame($bag['uses'], collect($bag['uses'])->sort()->values()->all(), $key);
        }

        $this->assertSame([131, 173, 327, 393], config('ecology_data.bags.cotton.uses'));
    }

    public function test_aqi_tables_are_contiguous(): void
    {
        foreach (config('ecology_data.aqi') as $key => $table) {
            foreach ($table['rows'] as $index => [$cLow, $cHigh, $iLow, $iHigh]) {
                $this->assertLessThan($cHigh, $cLow, $key);
                $this->assertLessThan($iHigh, $iLow, $key);

                if ($index > 0) {
                    $this->assertSame($table['rows'][$index - 1][3] + 1, $iLow, "{$key} index bands");
                }
            }
        }

        $this->assertSame([0.0, 9.0, 0, 50], config('ecology_data.aqi.pm25.rows.0'));
    }

    public function test_solar_cities_have_twelve_months_that_add_up(): void
    {
        $cities = config('ecology_data.solar_cities');

        $this->assertCount(260, $cities);

        foreach ($cities as $key => $city) {
            $this->assertCount(12, $city['monthly'], $key);
            $this->assertEqualsWithDelta($city['yearly'], array_sum($city['monthly']), 2, $key);
            $this->assertGreaterThan(500, $city['yearly'], $key);
            $this->assertLessThan(2600, $city['yearly'], $key);
        }
    }

    public function test_fish_mercury_and_reference_dose(): void
    {
        $fish = config('ecology_data.fish');

        $this->assertSame(0.995, $fish['swordfish']['ppm']);
        $this->assertSame(0.126, $fish['tuna_canned_light']['ppm']);
        $this->assertSame(0.1, config('ecology_data.mercury_rfd'));
    }
}
