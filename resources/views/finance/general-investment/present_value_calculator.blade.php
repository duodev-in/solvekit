<x-calc.page
    title="Present Value Calculator - SolveKit"
    description="Free present value calculator: what a future amount and a stream of payments are worth today at a discount rate."
    lede="Find what future money is worth today."
    about="PV = FV ÷ (1 + i)^N for a single amount, plus PMT × [1 − (1 + i)^−N] ÷ i for regular payments (times 1 + i if paid at the start). The discount rate reflects what you could earn elsewhere. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'present_value', 'fields' => ['future', 'payment', 'rate', 'years', 'compound', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Enter the future amount', 'text' => 'And any regular payment.'],
        ['name' => 'Enter the discount rate', 'text' => 'And years.'],
    ]"
    :faqs="[
        ['question' => 'What is $10,000 in 10 years worth today at 5%?', 'answer' => '$6,139.13.'],
        ['question' => 'What is $1,000 a year for 20 years worth at 5%?', 'answer' => '$12,462.21.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="future" label="Future value" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="payment" label="Payment each period" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Discount rate a year" value="5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="compound" label="Compounding" :options="['1' => 'Annually', '2' => 'Semi-annually', '4' => 'Quarterly', '12' => 'Monthly', '52' => 'Weekly', '365' => 'Daily', 'inf' => 'Continuously']" selected="1" />
        <x-calc.select name="per" label="Payments" :options="['12' => 'Monthly', '1' => 'Yearly', '4' => 'Quarterly', '26' => 'Every two weeks', '52' => 'Weekly']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Paid at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Present value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['future' => 10000, 'payment' => 0, 'rate' => 5, 'years' => 10, 'compound' => '1', 'per' => '1', 'timing' => 'end'],
        'Payments' => ['future' => 0, 'payment' => 1000, 'rate' => 5, 'years' => 20, 'compound' => '1', 'per' => '1', 'timing' => 'end'],
        'Monthly' => ['future' => 50000, 'payment' => 200, 'rate' => 6, 'years' => 15, 'compound' => '12', 'per' => '12', 'timing' => 'end'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lump' => ['label' => 'Of the future value'],
            'stream' => ['label' => 'Of the payments'],
            'discount' => ['label' => 'Total discount'],
            'factor' => ['label' => 'Discount factor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = FV ÷ (1 + i)^N</li>
            <li>+ PMT[1 − (1 + i)^−N] ÷ i</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
