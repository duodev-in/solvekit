<x-calc.page
    title="Pay Raise Calculator - SolveKit"
    description="Free pay raise calculator: new pay from a percentage or dollar raise, or the raise percentage between two salaries, with the real raise after inflation."
    lede="Work out a pay raise."
    about="New pay = current × (1 + raise %). Raise % = (new − current) ÷ current. The real raise subtracts inflation: (1 + raise) ÷ (1 + inflation) − 1. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'raise', 'fields' => ['mode', 'current', 'change', 'new_pay', 'inflation']]"
    :how-to="[
        ['name' => 'Enter current pay', 'text' => ''],
        ['name' => 'Enter the raise or new pay', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $60,000 after a 4% raise?', 'answer' => '$62,400.00.'],
        ['question' => 'What raise is $60,000 to $66,000?', 'answer' => '10%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="I know" :options="['percent' => 'The raise %', 'amount' => 'The raise amount', 'new' => 'The new pay']" selected="percent" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="current" label="Current pay" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="change" label="Raise (% or amount)" value="4" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="new_pay" label="New pay" value="63000" step="0.01" suffix="$" />
        <x-calc.field name="inflation" label="Inflation" value="2.7" step="any" suffix="%" />
    </div>

    <x-calc.result label="New pay" />

    <x-calc.options :decimals="false" :examples="[
        '4%' => ['mode' => 'percent', 'current' => 60000, 'change' => 4, 'new_pay' => '', 'inflation' => 2.7],
        '$3,000' => ['mode' => 'amount', 'current' => 60000, 'change' => 3000, 'new_pay' => '', 'inflation' => 2.7],
        'New pay' => ['mode' => 'new', 'current' => 60000, 'change' => '', 'new_pay' => 66000, 'inflation' => 2.7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'new' => ['label' => 'New pay'],
            'percent' => ['label' => 'Raise'],
            'monthly' => ['label' => 'More each month'],
            'real' => ['label' => 'Real raise'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>new = current × (1 + r)</li>
            <li>r = new ÷ current − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
