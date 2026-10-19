<x-calc.page
    title="Salary Inflation Calculator - SolveKit"
    description="Free salary inflation calculator: what a past salary is worth in today's dollars with the BLS CPI-U, and whether your raises kept up with inflation."
    lede="Check if your salary kept up with inflation."
    about="A salary from an earlier year is restated in another year's dollars by the ratio of CPI-U annual averages. If your current salary is below the adjusted figure, your real pay has fallen. 2026 is estimated from months published so far. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cpi', 'fields' => ['amount', 'from', 'to'], 'data' => ['cpi' => config('finance_data.cpi')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the salary and its year', 'text' => ''],
        ['name' => 'Compare with today', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a $55,000 salary from 2015 worth in 2026 dollars?', 'answer' => '$77,603.38.'],
        ['question' => 'What did $40,000 in 2000 equal in 2026?', 'answer' => '$77,677.12.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Salary" value="55000" step="0.01" suffix="$" />
        <x-calc.field name="from" label="Year of that salary" value="2015" min="1913" max="2026" step="1" />
        <x-calc.field name="to" label="Compare with year" value="2026" min="1913" max="2026" step="1" />
    </div>

    <x-calc.result label="Equivalent value" />

    <x-calc.options :decimals="false" :examples="[
        '2015 salary' => ['amount' => 55000, 'from' => 2015, 'to' => 2026],
        '2000 salary' => ['amount' => 40000, 'from' => 2000, 'to' => 2026],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'change' => ['label' => 'Prices rose'],
            'power' => ['label' => 'Average inflation'],
            'halving' => ['label' => 'CPI values'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>real salary = salary × CPI(to) ÷ CPI(from)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
