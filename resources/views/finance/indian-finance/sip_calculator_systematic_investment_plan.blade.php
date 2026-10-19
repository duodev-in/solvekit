<x-calc.page
    title="SIP Calculator — Systematic Investment Plan - SolveKit"
    description="Free SIP calculator: future value of monthly mutual fund investments with an optional yearly step-up, total invested, gains and a year-by-year table in rupees."
    lede="Find what your monthly SIP can grow to."
    about="SIP value = P × [(1 + i)^n − 1] ÷ i × (1 + i), with P the monthly instalment, i the monthly rate (annual ÷ 12) and n the months; instalments are made at the start of each month, as fund houses assume. Mutual fund returns are not guaranteed; equity funds have returned roughly 10–14% a year over long periods, with large swings. Equity gains over ₹1.25 lakh a year are taxed at 12.5% (LTCG). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'sip', 'fields' => ['monthly', 'rate', 'years', 'stepup'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the monthly amount', 'text' => ''],
        ['name' => 'Enter the return and years', 'text' => 'Add a step-up if you raise the SIP each year.'],
    ]"
    :faqs="[
        ['question' => 'What does ₹10,000 a month for 10 years at 12% become?', 'answer' => '₹23,23,391, from ₹12,00,000 invested.'],
        ['question' => 'And with a 10% yearly step-up?', 'answer' => '₹33,74,326.'],
        ['question' => 'And ₹5,000 a month for 25 years?', 'answer' => '₹94,88,175.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="monthly" label="Monthly SIP" value="10000" step="1" suffix="$" />
        <x-calc.field name="rate" label="Expected return a year" value="12" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
        <x-calc.field name="stepup" label="Yearly step-up" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Expected value" />

    <x-calc.options :decimals="false" :examples="[
        '₹10k for 10 years' => ['monthly' => 10000, 'rate' => 12, 'years' => 10, 'stepup' => 0],
        'With step-up' => ['monthly' => 10000, 'rate' => 12, 'years' => 10, 'stepup' => 10],
        '₹5k for 25 years' => ['monthly' => 5000, 'rate' => 12, 'years' => 25, 'stepup' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Value over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'invested' => ['label' => 'Amount invested'],
            'gains' => ['label' => 'Estimated gains'],
            'multiple' => ['label' => 'Multiple'],
            'xirr' => ['label' => 'Expected return'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV = P × [(1 + i)^n − 1] ÷ i × (1 + i)</li>
            <li>i = annual ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
