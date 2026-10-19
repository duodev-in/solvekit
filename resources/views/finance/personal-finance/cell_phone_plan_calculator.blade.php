<x-calc.page
    title="Cell Phone Plan Calculator - SolveKit"
    description="Free cell phone plan calculator: total cost of plans over a contract or comparison period, including device installments and upfront fees."
    lede="Compare cell phone plans."
    about="Total cost = (monthly plan + device installment) × months + upfront costs. Compare over the same period; promotional credits that end early change the picture. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'phone_plans', 'fields' => ['plans', 'months']]"
    :how-to="[
        ['name' => 'Add plans', 'text' => ''],
        ['name' => 'Set the period', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Which example plan is cheapest over 24 months?', 'answer' => 'Prepaid: $1,560.00 in total, $65.00 a month on average.'],
    ]"
>
    <x-calc.rows-editor name="plans" label="Plans" :columns="['name' => 'Plan', 'monthly' => 'Plan a month', 'device' => 'Device a month', 'upfront' => 'Upfront', 'lines' => 'Lines']" :rows="[['Carrier unlimited', 75, 30, 35, 1], ['Prepaid', 40, 0, 600, 1], ['Family plan', 160, 60, 0, 4]]" :text="['name']" />

    <x-calc.field name="months" label="Compare over" value="24" min="0" step="1" suffix="months" />

    <x-calc.result label="Cheapest" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['plans' => 'Carrier unlimited	75	30	35	1
Prepaid	40	0	600	1
Family plan	160	60	0	4', 'months' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'best' => ['label' => 'Total for the cheapest'],
            'gap' => ['label' => 'Most expensive costs more by'],
            'per_line' => ['label' => 'Per line a month'],
            'count' => ['label' => 'Plans'],
        ]" />
        <x-calc.quick-ref heading="Plans" name="plans" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = (plan + device) × months + upfront</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
