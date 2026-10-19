<?php

namespace Tests\Feature;

use Tests\TestCase;

class FoodDataTest extends TestCase
{
    public function test_ingredient_densities_match_usda_household_measures(): void
    {
        $ingredients = config('food_data.ingredients');

        $this->assertGreaterThanOrEqual(200, count($ingredients));
        $this->assertEquals(125, $ingredients['flour_ap']['cup']);
        $this->assertEquals(200, $ingredients['sugar']['cup']);
        $this->assertEquals(227, $ingredients['butter']['cup']);
        $this->assertEquals(220, $ingredients['sugar_brown_packed']['cup']);
        $this->assertEquals(339, $ingredients['honey']['cup']);
        $this->assertEquals(50, $ingredients['egg']['pieces']['large']);
        $this->assertEquals(40, $ingredients['coffee']['per100']['caffeine']);

        foreach ($ingredients as $key => $ingredient) {
            $this->assertArrayHasKey($ingredient['group'], config('food_data.groups'), $key);
            $this->assertIsNumeric($ingredient['per100']['kcal'], $key);
            $this->assertTrue(isset($ingredient['cup']) || isset($ingredient['pieces']) || $ingredient['group'] === 'protein', "{$key} has no measure");

            if (isset($ingredient['cup'])) {
                $this->assertGreaterThan(5, $ingredient['cup'], $key);
                $this->assertLessThan(400, $ingredient['cup'], $key);
            }
        }
    }

    public function test_foodkeeper_storage_times_are_complete(): void
    {
        $storage = config('food_data.storage');

        $this->assertGreaterThan(600, count($storage));

        foreach ($storage as $food) {
            $this->assertNotEmpty($food['times'], $food['name']);

            foreach ($food['times'] as [$place, $from, $min, $max, $unit]) {
                $this->assertContains($place, ['pantry', 'fridge', 'freezer']);
                $this->assertContains($from, ['', 'purchase', 'opening', 'thawing']);

                if (in_array($unit, ['hours', 'days', 'weeks', 'months', 'years'], true)) {
                    $this->assertLessThanOrEqual($max, $min, $food['name']);
                }
            }
        }
    }

    public function test_usda_cooking_charts(): void
    {
        $turkey = config('food_data.turkey');
        $this->assertSame(325, $turkey['roast_f']);
        $this->assertSame([12, 14, 3, 3.75], $turkey['unstuffed'][2]);

        foreach (['unstuffed', 'stuffed'] as $chart) {
            foreach ($turkey[$chart] as [$from, $to, $low, $high]) {
                $this->assertLessThan($to, $from);
                $this->assertLessThanOrEqual($high, $low);
            }
        }

        $ham = collect(config('food_data.ham'));
        $this->assertCount(14, $ham);
        $this->assertSame([15, 18], $ham->firstWhere('cut', 'bone-in, whole')['min_per_lb']);

        $safe = collect(config('food_data.safe'))->keyBy(1);
        $this->assertSame(165, $safe['All poultry (whole, parts, ground, giblets)'][2]);
        $this->assertSame(160, $safe['Beef, pork, veal, lamb (ground)'][2]);
        $this->assertSame(145, $safe['Steaks, roasts, chops'][2]);
        $this->assertSame(3, $safe['Steaks, roasts, chops'][3]);
    }

    public function test_candy_stages_rise_and_cake_servings_grow_with_size(): void
    {
        $previous = 0;

        foreach (config('food_data.candy') as [$key, $name, $low, $high]) {
            $this->assertGreaterThanOrEqual($previous, $low, $key);
            $this->assertLessThan($high, $low, $key);
            $previous = $high;
        }

        foreach (config('food_data.cakes.round') + config('food_data.cakes.square') as $size => [$party, $wedding]) {
            $this->assertLessThanOrEqual($wedding, $party, (string) $size);
        }
    }
}
