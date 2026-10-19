<x-calc.page
    title="Mortgage Penalty Calculator - SolveKit"
    description="Free mortgage prepayment penalty calculator for Canada: three months' interest or the interest rate differential (IRD) for breaking a fixed or variable mortgage."
    lede="Estimate the penalty for breaking a mortgage early."
    about="Canadian lenders charge three months' interest on a variable-rate mortgage, and the greater of three months' interest and the interest rate differential on a fixed rate. IRD = balance × (your rate − comparison rate) × months left ÷ 12. Banks often use posted rates minus your original discount, which raises the IRD; your mortgage contract has the exact method. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'penalty', 'fields' => ['balance', 'rate', 'remaining', 'compare', 'type'], 'sym' => 'CAD', 'currency' => 'CAD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the balance and rates', 'text' => ''],
        ['name' => 'Choose fixed or variable', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the penalty to break a C$400,000 fixed mortgage at 5.5% with 36 months left when 3-year rates are 4.2%?', 'answer' => 'C$15,600.00.'],
        ['question' => 'And a variable-rate mortgage?', 'answer' => 'C$5,500.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Balance" value="400000" step="0.01" suffix="C$" />
        <x-calc.field name="rate" label="Your rate" value="5.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="remaining" label="Months left in the term" value="36" min="0" step="1" suffix="months" />
        <x-calc.field name="compare" label="Comparison rate for that term" value="4.2" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Mortgage type" :options="['fixed' => 'Fixed rate', 'variable' => 'Variable rate']" selected="fixed" />
    </div>

    <x-calc.result label="Estimated prepayment penalty" />

    <x-calc.options :decimals="false" :examples="[
        'Fixed' => ['balance' => 400000, 'rate' => 5.5, 'remaining' => 36, 'compare' => 4.2, 'type' => 'fixed'],
        'Variable' => ['balance' => 400000, 'rate' => 5.5, 'remaining' => 36, 'compare' => 4.2, 'type' => 'variable'],
        'Rates rose' => ['balance' => 300000, 'rate' => 3, 'remaining' => 24, 'compare' => 4.5, 'type' => 'fixed'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'three' => ['label' => 'Three months\' interest'],
            'ird' => ['label' => 'Interest rate differential'],
            'basis' => ['label' => 'Rule'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>3 months = B × r × 3 ÷ 12</li>
            <li>IRD = B × (r − r_compare) × months ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
