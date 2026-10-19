<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthDataTest extends TestCase
{
    public function test_growth_charts_hold_cdc_and_who_lms_tables(): void
    {
        $growth = config('health_data.growth');

        foreach (['cdc_bmi', 'cdc_weight', 'cdc_stature', 'who_weight', 'who_length', 'who_head'] as $chart) {
            foreach (['male', 'female'] as $sex) {
                $this->assertGreaterThan(20, count($growth[$chart][$sex]), "{$chart} {$sex}");

                foreach ($growth[$chart][$sex] as [$months, $l, $m, $s]) {
                    $this->assertGreaterThan(0, $m, $chart);
                    $this->assertGreaterThan(0, $s, $chart);
                }
            }
        }

        $this->assertEquals([24, -2.01118107, 16.57502768, 0.080592465], $growth['cdc_bmi']['male'][0]);
        $this->assertEquals([0, 0.3809, 3.2322, 0.14171], $growth['who_weight']['female'][0]);
    }

    public function test_every_score_has_items_bands_and_a_source(): void
    {
        $scores = config('health_data.scores');

        $this->assertGreaterThanOrEqual(60, count($scores));

        foreach ($scores as $key => $score) {
            $this->assertNotEmpty($score['source'], $key);
            $this->assertNotEmpty($score['items'], $key);
            $this->assertNotEmpty($score['bands'], $key);

            $minimums = array_column($score['bands'], 0);
            $sorted = $minimums;
            sort($sorted);
            $this->assertSame($sorted, $minimums, "{$key} bands are not in order");

            foreach ($score['items'] as $item) {
                $this->assertContains($item['type'], ['check', 'choice'], $key);

                if ($item['type'] === 'choice') {
                    $this->assertArrayHasKey($item['default'], $item['options'], "{$key}.{$item['key']}");
                }
            }
        }
    }

    public function test_published_score_totals(): void
    {
        $scores = config('health_data.scores');

        $this->assertEquals(27, $scores['phq9']['max']);
        $this->assertEquals(21, $scores['gad7']['max']);
        $this->assertEquals(30, $scores['epds']['max']);
        $this->assertEquals(40, $scores['audit']['max']);
        $this->assertEquals(15, $scores['gcs']['max']);
        $this->assertEquals(9, $scores['cha2ds2vasc']['max']);
        $this->assertEquals(8, $scores['cha2ds2va']['max']);
        $this->assertEquals(20, $scores['news2']['max']);
        $this->assertEquals(24, $scores['sofa']['max']);
        $this->assertEquals(42, $scores['nihss']['max']);
        $this->assertEquals(100, $scores['barthel']['max']);
        $this->assertEquals(28, $scores['tinetti']['max']);
        $this->assertEquals(56, $scores['berg']['max']);
        $this->assertEquals(58.2, $scores['dasi']['max']);
        $this->assertEquals(9, $scores['wells_dvt']['max']);
        $this->assertSame(['key' => 'q9', 'min' => 1], array_intersect_key($scores['phq9']['alerts'][0], ['key' => 0, 'min' => 0]));
    }

    public function test_reference_intakes_and_activity_mets(): void
    {
        $dri = config('health_data.dri.nutrients');

        $this->assertEquals([900, false], $dri['vitamin_a']['rda']['males']['19-30 y']);
        $this->assertEquals([700, false], $dri['vitamin_a']['rda']['females']['19-30 y']);

        $mets = config('health_data.mets.activities');

        $this->assertEquals(3.5, $mets['walk'][1]);
        $this->assertEquals(9.8, $mets['run6'][1]);
    }

    public function test_army_fitness_test_tables(): void
    {
        $aft = config('health_data.aft');

        $this->assertSame(['mdl', 'hrp', 'sdc', 'plk', 'run'], array_keys($aft['events']));
        $this->assertSame(300, $aft['standards']['general']['total']);
        $this->assertSame(350, $aft['standards']['combat']['total']);
    }
}
