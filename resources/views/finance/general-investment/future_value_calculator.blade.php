<x-calc.page
    title="Future Value Calculator - SolveKit"
    description="Free future value calculator: future value of a lump sum and of regular payments at an interest rate, with any compounding and payments at the start or end of each period."
    lede="Find the future value of money today and regular payments."
    about="FV of a lump sum = PV(1 + i)^N. FV of regular payments = PMT × [(1 + i)^N − 1] ÷ i, times (1 + i) if paid at the start of each period. i is the rate per payment period. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'future_value', 'fields' => ['present', 'payment', 'rate', 'years', 'compound', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Enter the present value', 'text' => 'And any regular payment.'],
        ['name' => 'Enter the rate and time', 'text' => 'With compounding.'],
    ]"
    :faqs="[
        ['question' => 'What is the future value of $5,000 and $100 a month at 6% for 10 years?', 'answer' => '$25,484.92.'],
        ['question' => 'And of $5,000 alone?', 'answer' => '$9,096.98.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="present" label="Present value" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="payment" label="Payment each period" value="100" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Annual rate" value="6" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="12" />
        <x-calc.select name="per" label="Payments" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Paid at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Future value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['present' => 5000, 'payment' => 100, 'rate' => 6, 'years' => 10, 'compound' => '12', 'per' => '12', 'timing' => 'end'],
        'Lump only' => ['present' => 5000, 'payment' => 0, 'rate' => 6, 'years' => 10, 'compound' => '12', 'per' => '12', 'timing' => 'end'],
        'Annuity due' => ['present' => 0, 'payment' => 1000, 'rate' => 5, 'years' => 20, 'compound' => '1', 'per' => '1', 'timing' => 'start'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lump' => ['label' => 'From the present value'],
            'stream' => ['label' => 'From the payments'],
            'interest' => ['label' => 'Interest'],
            'factor' => ['label' => 'Growth factor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV = PV(1 + i)^N + PMT[(1 + i)^N − 1] ÷ i</li>
            <li>× (1 + i) for payments at the start</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
