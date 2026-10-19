<x-calc.page
    title="FICA Tax Calculator - SolveKit"
    description="Free FICA tax calculator for 2026: Social Security (6.2% up to $184,500) and Medicare (1.45% plus 0.9% Additional Medicare Tax) on wages, with the employer share."
    lede="Work out Social Security and Medicare taxes on your wages."
    about="FICA is 6.2% Social Security on wages up to the 2026 wage base of $184,500 and 1.45% Medicare on all wages, plus 0.9% Additional Medicare Tax on wages over $200,000 ($250,000 joint). Employers pay the same 7.65% (not the additional 0.9%). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'fica', 'fields' => ['wages', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter wages', 'text' => ''],
        ['name' => 'Choose status', 'text' => 'For the Additional Medicare Tax threshold.'],
    ]"
    :faqs="[
        ['question' => 'What FICA tax is due on $85,000?', 'answer' => '$6,502.50.'],
        ['question' => 'And on $250,000?', 'answer' => '$15,514.00; Social Security stops at the wage base.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wages" label="Wages" value="85000" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <x-calc.result label="FICA tax (employee)" />

    <x-calc.options :decimals="false" :examples="[
        '$85k' => ['wages' => 85000, 'status' => 'single'],
        '$250k' => ['wages' => 250000, 'status' => 'single'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ss' => ['label' => 'Social Security'],
            'medicare' => ['label' => 'Medicare'],
            'additional' => ['label' => 'Additional Medicare Tax'],
            'employer' => ['label' => 'Employer pays'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SS = 6.2% × min(wages, 184,500)</li>
            <li>Medicare = 1.45% × wages + 0.9% over 200,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
