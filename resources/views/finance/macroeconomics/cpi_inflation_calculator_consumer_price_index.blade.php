<x-calc.page
    title="CPI Inflation Calculator – Consumer Price Index - SolveKit"
    description="Free CPI inflation calculator: inflation between any two years from 1913 to 2026 using BLS CPI-U annual averages, with the cumulative and average yearly rate."
    lede="Measure inflation between two years."
    about="Inflation = CPI(later) ÷ CPI(earlier) − 1; average yearly inflation = (CPI ratio)^(1 ÷ years) − 1. CPI-U covers urban consumers, about 93% of the US population. 2026 is estimated from months published so far. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cpi', 'fields' => ['amount', 'from', 'to'], 'data' => ['cpi' => config('finance_data.cpi')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter years', 'text' => ''],
        ['name' => 'Read the inflation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much inflation was there from 2000 to 2026?', 'answer' => '94.19% in total, 2.585% a year on average.'],
        ['question' => 'From 2020 to 2025?', 'answer' => '24.38%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="from" label="From year" value="2000" min="1913" max="2026" step="1" />
        <x-calc.field name="to" label="To year" value="2026" min="1913" max="2026" step="1" />
    </div>

    <x-calc.result label="Equivalent value" />

    <x-calc.options :decimals="false" :examples="[
        '2000 to 2026' => ['amount' => 1000, 'from' => 2000, 'to' => 2026],
        '2020 to 2025' => ['amount' => 1000, 'from' => 2020, 'to' => 2025],
        '1970s' => ['amount' => 1000, 'from' => 1970, 'to' => 1980],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'change' => ['label' => 'Cumulative inflation'],
            'power' => ['label' => 'Average inflation'],
            'halving' => ['label' => 'CPI values'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>inflation = CPI₂ ÷ CPI₁ − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
