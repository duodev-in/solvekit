<x-calc.page
    title="Child Tax Credit Calculator - SolveKit"
    description="Free child tax credit calculator for 2026: $2,200 per child under 17, the $1,700 refundable portion and the income phase-out."
    lede="Work out your 2026 child tax credit."
    about="For 2026 the credit is $2,200 per qualifying child under 17 (indexed after the One Big Beautiful Bill Act) and $500 for other dependents. It falls by $50 for each $1,000 of modified AGI over $200,000 ($400,000 joint). Up to $1,700 per child is refundable as the additional child tax credit (15% of earned income over $2,500). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'ctc', 'fields' => ['agi', 'children', 'others', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter income', 'text' => ''],
        ['name' => 'Enter children and dependents', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the credit for two children at $85,000 married?', 'answer' => '$4,400.00.'],
        ['question' => 'And at $450,000?', 'answer' => '$1,900.00.'],
        ['question' => 'What if income is only $20,000?', 'answer' => '$2,625.00: the refundable part is limited to 15% of earnings over $2,500.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="agi" label="Modified AGI" value="85000" step="0.01" suffix="$" />
        <x-calc.field name="children" label="Children under 17" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="others" label="Other dependents" value="0" min="0" step="1" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="mfj" />
    </div>

    <x-calc.result label="Child tax credit you can use" />

    <x-calc.options :decimals="false" :examples="[
        'Two children' => ['agi' => 85000, 'children' => 2, 'others' => 0, 'status' => 'mfj'],
        'High income' => ['agi' => 450000, 'children' => 2, 'others' => 0, 'status' => 'mfj'],
        'Low income' => ['agi' => 20000, 'children' => 2, 'others' => 0, 'status' => 'hoh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'credit' => ['label' => 'Credit after phase-out'],
            'refundable' => ['label' => 'Refundable part'],
            'used' => ['label' => 'Used against tax'],
            'tax' => ['label' => 'Tax after the credit'],
            'phaseout' => ['label' => 'Phase-out'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>credit = $2,200 × children − $50 per $1,000 over threshold</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
