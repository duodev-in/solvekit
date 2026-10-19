<x-calc.page
    title="Time Value of Money Calculator - SolveKit"
    description="Free time value of money calculator: solve for PV, FV, payment, number of periods or interest rate, like a financial calculator, with payments at the start or end."
    lede="Solve any one of N, I/Y, PV, PMT and FV."
    about="The TVM equation links five values: PV(1 + i)^N + PMT(1 + i·type)[(1 + i)^N − 1] ÷ i + FV = 0. Money you pay out is negative and money you receive is positive, as on a BA II Plus or HP 12C. The rate is solved numerically. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'tvm', 'fields' => ['solve', 'n', 'rate', 'pv', 'pmt', 'fv', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Choose what to solve', 'text' => 'Then enter the other four.'],
        ['name' => 'Mind the signs', 'text' => 'Paid out is negative, received is positive.'],
    ]"
    :faqs="[
        ['question' => 'What does −$10,000 plus −$100 a month become in 10 years at 6%?', 'answer' => '$34,581.90.'],
        ['question' => 'What monthly payment repays $200,000 in 30 years at 6%?', 'answer' => '−$1,199.10 (negative: you pay it).'],
        ['question' => 'How many months to repay $5,000 at 18% paying $200?', 'answer' => '31.57.'],
    ]"
>
    <x-calc.segmented name="solve" legend="Solve for" :options="['fv' => 'FV', 'pv' => 'PV', 'pmt' => 'PMT', 'n' => 'N', 'rate' => 'I/Y']" selected="fv" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="N (number of periods)" value="120" min="0" step="any" />
        <x-calc.field name="rate" label="I/Y (annual rate)" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pv" label="PV (present value)" value="-10000" step="0.01" suffix="$" />
        <x-calc.field name="pmt" label="PMT (payment)" value="-100" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fv" label="FV (future value)" value="0" step="0.01" suffix="$" />
        <x-calc.select name="per" label="Periods a year (P/Y)" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Payments at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Future value' => ['solve' => 'fv', 'n' => 120, 'rate' => 6, 'pv' => -10000, 'pmt' => -100, 'fv' => 0, 'per' => '12', 'timing' => 'end'],
        'Mortgage payment' => ['solve' => 'pmt', 'n' => 360, 'rate' => 6, 'pv' => 200000, 'pmt' => '', 'fv' => 0, 'per' => '12', 'timing' => 'end'],
        'Periods' => ['solve' => 'n', 'n' => '', 'rate' => 18, 'pv' => 5000, 'pmt' => -200, 'fv' => 0, 'per' => '12', 'timing' => 'end'],
        'Rate' => ['solve' => 'rate', 'n' => 60, 'rate' => '', 'pv' => 20000, 'pmt' => -400, 'fv' => 0, 'per' => '12', 'timing' => 'end'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'periods' => ['label' => 'Periods'],
            'periodic' => ['label' => 'Rate per period'],
            'effective' => ['label' => 'Effective annual rate'],
            'total' => ['label' => 'Total payments'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV(1 + i)^N + PMT(1 + i·type)[(1 + i)^N − 1] ÷ i + FV = 0</li>
            <li>i = I/Y ÷ P/Y</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
