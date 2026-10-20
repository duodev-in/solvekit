<x-calc.page
    title="Doubling Time Calculator - SolveKit"
    description="Free doubling time calculator: how long a quantity takes to double at a growth rate (compound or continuous), compared with the rule of 70 and 72."
    lede="Work out the doubling time."
    about="At a growth rate r per period, a quantity doubles after T = ln 2 ÷ ln(1 + r) periods (compound) or ln 2 ÷ r (continuous). The rules of 70 and 72 divide 70 or 72 by the rate in percent as a quick estimate: 7% growth doubles in about 10 periods."
    :calc="['engine' => 'mt-percent', 'tool' => 'doubling', 'fields' => ['mode', 'rate', 'compounding', 'start', 'end', 'periods']]"
    :how-to="[
        ['name' => 'Choose rate or values', 'text' => ''],
        ['name' => 'Enter the numbers', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does 7% growth take to double?', 'answer' => '10.2448 periods.'],
        ['question' => 'What if 100 grew to 150 in 5 years?', 'answer' => '8.54756 periods.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['rate' => 'A growth rate', 'values' => 'Start and end values']" selected="rate" />

    <div data-show-when="mode:rate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="rate" label="Growth rate per period" value="7" step="any" suffix="%" />
            <x-calc.select name="compounding" label="Growth" :options="['compound' => 'Compound (per period)', 'continuous' => 'Continuous']" selected="compound" />
        </div>
    </div>

    <div data-show-when="mode:values" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="start" label="Start value" value="100" step="any" />
            <x-calc.field name="end" label="End value" value="150" step="any" />
            <x-calc.field name="periods" label="Periods between" value="5" step="any" />
        </div>
    </div>

    <x-calc.result label="Doubling time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'rate', 'rate' => 7, 'compounding' => 'compound', 'start' => 100, 'end' => 150, 'periods' => 5],
        'Values' => ['mode' => 'values', 'rate' => 7, 'compounding' => 'compound', 'start' => 100, 'end' => 150, 'periods' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rate' => ['label' => 'Growth rate'],
            'rule70' => ['label' => 'Rule of 70'],
            'rule72' => ['label' => 'Rule of 72'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T = ln 2 ÷ ln(1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
