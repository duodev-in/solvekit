<x-calc.page
    title="Compound Interest Rate Calculator - SolveKit"
    description="Free compound interest rate calculator: the annual rate that grows a starting amount to an ending amount over a number of years, for any compounding."
    lede="Find the interest rate behind a growth."
    about="Solving A = P(1 + r/n)^(nt) for r gives r = n[(A/P)^(1/(nt)) − 1]; with continuous compounding r = ln(A/P) ÷ t. The effective annual rate is (A/P)^(1/t) − 1 whatever the compounding. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'compound_rate', 'fields' => ['start', 'end', 'years', 'compound']]"
    :how-to="[
        ['name' => 'Enter both amounts', 'text' => 'And the years between them.'],
        ['name' => 'Choose the compounding', 'text' => 'For the nominal rate.'],
    ]"
    :faqs="[
        ['question' => 'What rate turns $10,000 into $15,000 in 6 years, compounded monthly?', 'answer' => '6.777% nominal, 6.991% effective.'],
        ['question' => 'What rate doubles money in 10 years?', 'answer' => '7.177% compounded annually.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting amount" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Ending amount" value="15000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="6" min="0" step="any" suffix="years" />
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="12" />
    </div>

    <x-calc.result label="Annual interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => 10000, 'end' => 15000, 'years' => 6, 'compound' => '12'],
        'Doubling' => ['start' => 1, 'end' => 2, 'years' => 10, 'compound' => '1'],
        'Continuous' => ['start' => 500, 'end' => 800, 'years' => 4, 'compound' => 'inf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'effective' => ['label' => 'Effective annual rate'],
            'total' => ['label' => 'Total growth'],
            'multiple' => ['label' => 'Multiple'],
            'doubling' => ['label' => 'Doubling time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = n[(A/P)^(1/(nt)) − 1]</li>
            <li>continuous: r = ln(A/P) ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
