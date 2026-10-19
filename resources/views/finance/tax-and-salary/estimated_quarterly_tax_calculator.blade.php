<x-calc.page
    title="Estimated Quarterly Tax Calculator - SolveKit"
    description="Free estimated quarterly tax calculator: the safe-harbor payment to avoid an underpayment penalty, from last year's tax (100% or 110%) or 90% of this year's."
    lede="Work out your quarterly estimated tax payments."
    about="To avoid the underpayment penalty, pay the smaller of 90% of this year's tax and 100% of last year's (110% if last year's AGI was over $150,000, $75,000 married filing separately), through withholding and four equal estimated payments (Form 1040-ES). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'estimated', 'fields' => ['this_year', 'last_year', 'last_agi', 'withheld', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter this year\'s and last year\'s tax', 'text' => ''],
        ['name' => 'Subtract withholding', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What should each payment be with $24,000 of tax this year and $20,000 last year?', 'answer' => '$3,500.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="this_year" label="Expected tax this year" value="24000" step="0.01" suffix="$" />
        <x-calc.field name="last_year" label="Total tax last year" value="20000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="last_agi" label="Last year's AGI" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="withheld" label="Expected withholding" value="6000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <x-calc.result label="Each quarterly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['this_year' => 24000, 'last_year' => 20000, 'last_agi' => 120000, 'withheld' => 6000, 'status' => 'single'],
        'High income' => ['this_year' => 60000, 'last_year' => 50000, 'last_agi' => 220000, 'withheld' => 10000, 'status' => 'single'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'prior' => ['label' => 'Prior-year safe harbor'],
            'current' => ['label' => '90% of this year'],
            'required' => ['label' => 'Required for the year'],
            'dates' => ['label' => 'Due dates'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>required = min(90% × this year, 100% or 110% × last year) − withholding</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
