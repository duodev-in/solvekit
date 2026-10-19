<x-calc.page
    title="Inflation Calculator - SolveKit"
    description="Free inflation calculator: past values with BLS CPI data (1913–2026) or future costs at a constant inflation rate."
    lede="Adjust money for inflation."
    about="Historical mode uses CPI-U annual averages: value × CPI(to) ÷ CPI(from). Future mode compounds a constant rate: cost × (1 + inflation)^years. Purchasing power halves in about 72 ÷ rate years. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cpi', 'fields' => ['mode', 'amount', 'from', 'to', 'amount', 'rate', 'years'], 'data' => ['cpi' => config('finance_data.cpi')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Choose history or a rate', 'text' => ''],
        ['name' => 'Enter the amount and period', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $1,000 from 2010 worth in 2026?', 'answer' => '$1,533.24.'],
        ['question' => 'What will $1,000 cost in 20 years at 3%?', 'answer' => '$1,806.11.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Use" :options="['cpi' => 'CPI history', 'rate' => 'A constant rate']" selected="cpi" />

    <div data-show-when="mode:cpi">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="amount" label="Amount" value="1000" step="0.01" suffix="$" />
            <x-calc.field name="from" label="From year" value="2010" min="1913" max="2026" step="1" />
            <x-calc.field name="to" label="To year" value="2026" min="1913" max="2026" step="1" />
        </div>
    </div>

    <div data-show-when="mode:rate" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="amount" label="Amount" value="1000" step="0.01" suffix="$" />
            <x-calc.field name="rate" label="Inflation a year" value="3" step="any" suffix="%" />
            <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
        </div>
    </div>

    <x-calc.result label="Equivalent value" />

    <x-calc.options :decimals="false" :examples="[
        'History' => ['mode' => 'cpi', 'amount' => 1000, 'from' => 2010, 'to' => 2026, 'rate' => '', 'years' => ''],
        'Future' => ['mode' => 'rate', 'amount' => 1000, 'from' => '', 'to' => '', 'rate' => 3, 'years' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'change' => ['label' => 'Change'],
            'power' => ['label' => 'Average or buying power'],
            'halving' => ['label' => 'Detail'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CPI: value × CPI₂ ÷ CPI₁</li>
            <li>rate: value × (1 + π)^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
