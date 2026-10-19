<x-calc.page
    title="AMT Calculator - SolveKit"
    description="Free AMT calculator for 2026: alternative minimum taxable income, exemption with phase-out, tentative minimum tax at 26%/28% and whether you owe AMT."
    lede="Check whether you owe the alternative minimum tax."
    about="AMTI = taxable income + preference items (state and local taxes deducted, ISO bargain element, others; add the standard deduction back if taken). For 2026 the exemption is $90,100 single and $140,200 joint, reduced by 50% of AMTI over $500,000 / $1,000,000. Tentative tax is 26% up to $244,500 and 28% above; AMT is the excess over regular tax. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'amt', 'fields' => ['income', 'status', 'salt', 'iso', 'other_pref', 'standard_taken'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter taxable income', 'text' => ''],
        ['name' => 'Add preference items', 'text' => 'ISOs are the most common AMT trigger.'],
    ]"
    :faqs="[
        ['question' => 'Does exercising ISOs with a $150,000 spread trigger AMT at $300,000 income?', 'answer' => 'AMT of $24,912.75.'],
        ['question' => 'And without the ISO exercise?', 'answer' => '$0.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Regular taxable income" value="300000" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salt" label="State and local taxes deducted" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="iso" label="ISO bargain element" value="150000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other_pref" label="Other preferences" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="standard_taken" label="Took the standard deduction" :checked="false" />

    <x-calc.result label="Alternative minimum tax" />

    <x-calc.options :decimals="false" :examples="[
        'ISO exercise' => ['income' => 300000, 'status' => 'single', 'salt' => 10000, 'iso' => 150000, 'other_pref' => 0, 'standard_taken' => false],
        'No ISOs' => ['income' => 300000, 'status' => 'single', 'salt' => 10000, 'iso' => 0, 'other_pref' => 0, 'standard_taken' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'amti' => ['label' => 'AMTI'],
            'exemption' => ['label' => 'Exemption'],
            'tmt' => ['label' => 'Tentative minimum tax'],
            'regular' => ['label' => 'Regular tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AMTI = taxable + preferences</li>
            <li>TMT = 26% × min(base, 244,500) + 28% × rest</li>
            <li>AMT = max(0, TMT − regular)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
