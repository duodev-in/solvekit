<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Tests\TestCase;

class EverydayDataTest extends TestCase
{
    public function test_chinese_new_year_dates_fall_between_21_january_and_20_february(): void
    {
        $dates = config('everyday_data.chinese_new_year');

        $this->assertCount(200, $dates);
        $this->assertSame('2024-02-10', $dates[2024]);
        $this->assertSame('2026-02-17', $dates[2026]);

        foreach ($dates as $year => $date) {
            $day = CarbonImmutable::parse($date);

            $this->assertSame($year, $day->year, (string) $year);
            $this->assertTrue($day->between(CarbonImmutable::create($year, 1, 21), CarbonImmutable::create($year, 2, 20)), (string) $year);
        }
    }

    public function test_irs_mileage_rates_for_2026(): void
    {
        $rates = collect(config('everyday_data.irs_mileage'))->keyBy(0);

        $this->assertSame(76, $rates['business_2026b'][2]);
        $this->assertSame(72.5, $rates['business_2026a'][2]);
        $this->assertSame(14, $rates['charity'][2]);
    }

    public function test_tesla_ratings_are_plausible(): void
    {
        foreach (config('everyday_data.tesla') as [$key, $name, $kwh, $range]) {
            $this->assertGreaterThan(20, $kwh, $key);
            $this->assertLessThan(50, $kwh, $key);
            $this->assertGreaterThan(200, $range, $key);
        }
    }

    public function test_gmat_and_sat_percentiles_rise_with_score(): void
    {
        $gmat = config('everyday_data.gmat');
        $this->assertCount(61, $gmat);
        $this->assertSame(85.6, $gmat[645][0]);

        $previous = -1;

        foreach ($gmat as $score => [$percentile]) {
            $this->assertGreaterThanOrEqual($previous, $percentile, (string) $score);
            $previous = $percentile;
        }

        $sat = config('everyday_data.sat_total');
        $this->assertCount(121, $sat);
        $this->assertSame(['81', '75'], $sat[1200]);
    }

    public function test_film_runtimes_and_best_picture_list(): void
    {
        $films = config('everyday_data.best_picture');

        $this->assertCount(98, $films);
        $this->assertSame([2026, 'One Battle After Another', 162], end($films));

        foreach ($films as [$year, $title, $minutes]) {
            $this->assertGreaterThan(80, $minutes, $title);
            $this->assertLessThan(240, $minutes, $title);
        }

        foreach (config('everyday_data.middle_earth') as [$key, $title, $year, $theatrical, $extended]) {
            $this->assertGreaterThanOrEqual($theatrical, $extended, $title);
        }
    }

    public function test_money_and_paper_tables(): void
    {
        $money = config('everyday_data.money');

        $this->assertSame(1.0, $money['usd_note_100'][2]);
        $this->assertSame(5.67, $money['usd_quarter'][2]);
        $this->assertSame(['Bond / writing', 17, 22], config('everyday_data.paper_grades.bond'));
    }

    public function test_source_site_ratios_and_eui_medians(): void
    {
        $this->assertSame(2.8, config('everyday_data.source_site.electricity.3'));
        $this->assertSame([116.4, 52.9], array_slice(config('everyday_data.eui_medians.office'), 1));
    }
}
