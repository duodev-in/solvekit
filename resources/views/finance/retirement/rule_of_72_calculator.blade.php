<x-calc.page
    title="Rule of 72 Calculator - SolveKit"
    description="Free Rule of 72 calculator: years to double money at a rate, or the rate needed to double in a number of years, compared with the exact answer."
    lede="Estimate doubling time with the Rule of 72."
    about="Years to double ≈ 72 ÷ rate (in %). The exact time is ln 2 ÷ ln(1 + r). 72 works best around 6–10%; 69.3 is exact for continuous compounding, and 70 is a common variant. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'rule72', 'fields' => ['mode', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => ''],
        ['name' => 'Enter the rate or years', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does money take to double at 8%?', 'answer' => '9 years; exactly 9.006 years.'],
        ['question' => 'What rate doubles money in 10 years?', 'answer' => '7.2%; exactly 7.177%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['years' => 'Years to double', 'rate' => 'Rate needed']" selected="years" />

    <div data-show-when="mode:years">
        <x-calc.field name="rate" label="Annual return" value="8" step="any" suffix="%" />
    </div>

    <div data-show-when="mode:rate" hidden>
        <x-calc.field name="years" label="Years to double" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Years to double" />

    <x-calc.options :decimals="false" :examples="[
        'At 8%' => ['mode' => 'years', 'rate' => 8, 'years' => ''],
        'At 3%' => ['mode' => 'years', 'rate' => 3, 'years' => ''],
        'In 10 years' => ['mode' => 'rate', 'rate' => '', 'years' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'exact' => ['label' => 'Exact'],
            'rule69' => ['label' => 'Rule of 69.3'],
            'rule70' => ['label' => 'Rule of 70'],
            'error' => ['label' => 'Rule of 72 error'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t ≈ 72 ÷ r%</li>
            <li>exact t = ln 2 ÷ ln(1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
