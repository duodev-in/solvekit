<?php

namespace Tests\Feature;

use Tests\TestCase;

class FinanceDataTest extends TestCase
{
    public function test_federal_2026_tables_match_rev_proc_2025_32(): void
    {
        $federal = config('finance_data.federal');

        $this->assertSame(2026, $federal['year']);
        $this->assertSame(16100, $federal['standard']['single']);
        $this->assertSame(32200, $federal['standard']['mfj']);
        $this->assertSame([640600, 0.37], end($federal['brackets']['single']));
        $this->assertSame([768700, 0.37], end($federal['brackets']['mfj']));
        $this->assertSame(184500, $federal['fica']['wage_base']);
        $this->assertSame(2200, $federal['ctc']['amount']);

        foreach ($federal['brackets'] as $status => $brackets) {
            $previous = -1;

            foreach ($brackets as [$from, $rate]) {
                $this->assertGreaterThan($previous, $from, $status);
                $previous = $from;
            }
        }
    }

    public function test_every_state_and_dc_has_a_table(): void
    {
        $states = config('finance_data.states.list');

        $this->assertCount(51, $states);

        foreach (['AK', 'FL', 'NV', 'NH', 'SD', 'TN', 'TX', 'WA', 'WY'] as $code) {
            $this->assertSame([], $states[$code]['single'], $code);
        }

        $this->assertSame([1000000, 0.133], end($states['CA']['single']));
        $this->assertSame([[0, 0.0495]], $states['IL']['single']);
        $this->assertCount(51, config('finance_data.sales.rates'));
        $this->assertSame(7.25, config('finance_data.sales.rates.CA.state'));
    }

    public function test_retirement_limits_and_rmd_table(): void
    {
        $this->assertSame(24500, config('finance_data.limits.deferral'));
        $this->assertSame(7500, config('finance_data.limits.ira'));
        $this->assertSame(26.5, config('finance_data.rmd.table.73'));
        $this->assertSame(2.0, config('finance_data.rmd.table.120'));
    }

    public function test_cpi_series_covers_1913_to_2026(): void
    {
        $cpi = config('finance_data.cpi.annual');

        $this->assertSame(9.9, $cpi[1913]);
        $this->assertCount(114, $cpi);
        $this->assertGreaterThan($cpi[2000], $cpi[2025]);
    }

    public function test_country_tables(): void
    {
        $this->assertSame(12570, config('finance_data.uk.personal_allowance'));
        $this->assertSame([[0, 0], [400000, 0.05], [800000, 0.10], [1200000, 0.15], [1600000, 0.20], [2000000, 0.25], [2400000, 0.30]], config('finance_data.india.new.slabs'));
        $this->assertSame(7.1, config('finance_data.smallsavings.ppf'));
        $this->assertSame([42, 84, 126, 168, 210], config('finance_data.apy.chart.18'));
        $this->assertSame(3938.58, config('finance_data.vadisability.alone.100'));
    }

    public function test_currency_menu_matches_the_script_list(): void
    {
        $currencies = config('currencies');
        $script = file_get_contents(resource_path('js/calc/currency.js'));

        $this->assertArrayHasKey('INR', $currencies);
        $this->assertArrayHasKey('USD', $currencies);

        preg_match_all("/\\['([A-Z]{3})', '([^']+)', '([^']+)'\\]/u", $script, $matches, PREG_SET_ORDER);

        $this->assertSame($currencies, collect($matches)->mapWithKeys(fn (array $match) => [$match[1] => [$match[2], $match[3]]])->all());
    }
}
