<x-calc.page
    title="New York Tax Calculator - SolveKit"
    description="Free New York income tax calculator for 2026: New York State tax plus New York City resident tax, with effective and marginal rates."
    lede="Estimate New York State and City income tax."
    about="New York State has nine brackets from 3.9% to 10.9%. New York City residents also pay city income tax of 3.078% to 3.876%. High earners lose the benefit of lower brackets (tax benefit recapture), which this estimate does not include. State tax = (income − standard deduction − personal exemptions) taxed through the state's 2026 brackets, less any credits that replace deductions. Figures come from the Tax Foundation's 2026 table; local income taxes, phase-outs, special credits and federal-deduction states are simplified, so treat the result as an estimate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'new_york', 'fields' => ['income', 'status', 'dependents', 'nyc'], 'data' => ['states' => config('finance_data.states')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter income and status', 'text' => ''],
        ['name' => 'Tick NYC resident', 'text' => 'If you live in one of the five boroughs.'],
    ]"
    :faqs="[
        ['question' => 'What do NYC residents pay on $100,000?', 'answer' => '$8,300.84.'],
        ['question' => 'And outside the city?', 'answer' => '$4,859.75.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Income (federal AGI)" value="100000" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly']" selected="single" />
        <x-calc.field name="dependents" label="Dependents" value="0" min="0" step="1" />
    </div>

    <x-calc.checkbox name="nyc" label="New York City resident" :checked="true" />

    <x-calc.result label="New York income tax" />

    <x-calc.options :decimals="false" :examples="[
        'NYC $100k' => ['income' => 100000, 'status' => 'single', 'dependents' => 0, 'nyc' => true],
        'Upstate $100k' => ['income' => 100000, 'status' => 'single', 'dependents' => 0, 'nyc' => false],
        'Married NYC' => ['income' => 250000, 'status' => 'mfj', 'dependents' => 2, 'nyc' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'state' => ['label' => 'State tax'],
            'nyc' => ['label' => 'City tax'],
            'taxable' => ['label' => 'Taxable income'],
            'marginal' => ['label' => 'Combined marginal rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>state = NY brackets</li>
            <li>city = NYC brackets on the same taxable income</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
