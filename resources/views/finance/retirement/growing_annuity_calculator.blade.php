<x-calc.page
    title="Growing Annuity Calculator - SolveKit"
    description="Free growing annuity calculator: present and future value of yearly payments that grow at a constant rate, such as rising pensions or rents."
    lede="Value payments that grow each year."
    about="PV = P ÷ (r − g) × [1 − ((1 + g) ÷ (1 + r))^n], with P the first payment (end of year 1); if r = g, PV = nP ÷ (1 + r). FV = PV × (1 + r)^n. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'growing_annuity', 'fields' => ['payment', 'rate', 'growth', 'years']]"
    :how-to="[
        ['name' => 'Enter the first payment', 'text' => ''],
        ['name' => 'Enter rate, growth and years', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $10,000 a year growing 3% for 20 years worth at 6%?', 'answer' => '$145,615.33.'],
        ['question' => 'And forever?', 'answer' => '$333,333.33.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="First payment" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Discount rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="growth" label="Growth rate" value="3" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="20" min="0" step="1" suffix="years" />
    </div>

    <x-calc.result label="Present value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['payment' => 10000, 'rate' => 6, 'growth' => 3, 'years' => 20],
        'Equal rates' => ['payment' => 5000, 'rate' => 4, 'growth' => 4, 'years' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fv' => ['label' => 'Future value'],
            'total' => ['label' => 'Total payments'],
            'last' => ['label' => 'Last payment'],
            'perpetuity' => ['label' => 'If it lasted forever'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = P ÷ (r − g) × [1 − ((1 + g)/(1 + r))^n]</li>
            <li>FV = PV(1 + r)^n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
