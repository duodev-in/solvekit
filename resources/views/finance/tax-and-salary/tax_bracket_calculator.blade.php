<x-calc.page
    title="Tax Bracket Calculator - SolveKit"
    description="Free tax bracket calculator for 2026: your federal marginal bracket, effective rate and the tax in each bracket, for every filing status."
    lede="Find your 2026 federal tax bracket."
    about="US income tax is progressive: each rate applies only to the income inside its bracket. For 2026 the rates are 10%, 12%, 22%, 24%, 32%, 35% and 37% (IRS Rev. Proc. 2025-32). Your marginal rate is the rate on your last dollar; the effective rate is total tax ÷ income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'tax_bracket', 'fields' => ['income', 'basis', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your income', 'text' => ''],
        ['name' => 'Choose your filing status', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What bracket is $90,000 single in 2026?', 'answer' => '22%, with $10,970.00 of tax.'],
        ['question' => 'And $200,000 married filing jointly?', 'answer' => '22%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Income" value="90000" step="0.01" suffix="$" />
        <x-calc.select name="basis" label="Income is" :options="['gross' => 'Gross (take the standard deduction)', 'taxable' => 'Already taxable income']" selected="gross" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <x-calc.result label="Marginal tax bracket" />

    <x-calc.options :decimals="false" :examples="[
        'Single $90k' => ['income' => 90000, 'basis' => 'gross', 'status' => 'single'],
        'Married $200k' => ['income' => 200000, 'basis' => 'gross', 'status' => 'mfj'],
        'Head of household' => ['income' => 65000, 'basis' => 'gross', 'status' => 'hoh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tax' => ['label' => 'Federal income tax'],
            'effective' => ['label' => 'Effective rate'],
            'taxable' => ['label' => 'Taxable income'],
            'next' => ['label' => 'Next bracket'],
        ]" />
        <x-calc.quick-ref heading="Tax by bracket" name="slices" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = Σ rateₖ × income in bracket k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
