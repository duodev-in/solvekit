<x-calc.page
    title="Buying Power Calculator - SolveKit"
    description="Free buying power calculator: what an amount from one year is worth in another year's dollars, from the BLS CPI-U (1913–2026)."
    lede="Compare buying power across years."
    about="Equivalent value = amount × CPI in the target year ÷ CPI in the original year, using CPI-U annual averages (1982–84 = 100). It measures average consumer prices; your own costs may have risen faster or slower. 2026 is estimated from the months published so far. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cpi', 'fields' => ['amount', 'from', 'to'], 'data' => ['cpi' => config('finance_data.cpi')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the amount and years', 'text' => ''],
        ['name' => 'Read the equivalent', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $100 from 1990 worth in 2026?', 'answer' => '$255.85.'],
        ['question' => 'And $1 from 1950?', 'answer' => '$13.88.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="from" label="From year" value="1990" min="1913" max="2026" step="1" />
        <x-calc.field name="to" label="To year" value="2026" min="1913" max="2026" step="1" />
    </div>

    <x-calc.result label="Equivalent value" />

    <x-calc.options :decimals="false" :examples="[
        '1990 to 2026' => ['amount' => 100, 'from' => 1990, 'to' => 2026],
        '1950 dollar' => ['amount' => 1, 'from' => 1950, 'to' => 2026],
        'Back in time' => ['amount' => 50000, 'from' => 2026, 'to' => 2000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'change' => ['label' => 'Price change'],
            'power' => ['label' => 'Average inflation'],
            'halving' => ['label' => 'CPI values'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = amount × CPI(to) ÷ CPI(from)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
