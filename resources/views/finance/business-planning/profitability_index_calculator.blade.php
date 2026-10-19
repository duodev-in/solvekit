<x-calc.page
    title="Profitability Index Calculator - SolveKit"
    description="Free profitability index calculator: PV of future cash flows ÷ initial investment, with NPV and IRR."
    lede="Rank projects by value per dollar invested."
    about="PI = PV of future cash flows ÷ initial investment. Above 1 means a positive NPV. It helps rank projects when capital is limited. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'profitability_index', 'fields' => ['investment', 'rate', 'flows']]"
    :how-to="[
        ['name' => 'Enter the investment and rate', 'text' => ''],
        ['name' => 'List the cash flows', 'text' => 'Year 1 first.'],
    ]"
    :faqs="[
        ['question' => 'What is the PI of $100,000 returning 30k, 40k, 50k, 20k at 10%?', 'answer' => '1.116; NPV $11,556.59.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="investment" label="Initial investment" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Discount rate" value="10" step="any" suffix="%" />
    </div>

    <x-calc.textarea name="flows" label="Yearly cash flows (one per line)" value="30000
40000
50000
20000" rows="5" />

    <x-calc.result label="Profitability index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['investment' => 100000, 'rate' => 10, 'flows' => '30000
40000
50000
20000'],
        'Marginal' => ['investment' => 10000, 'rate' => 12, 'flows' => '3000
3000
3000
3000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pv' => ['label' => 'PV of cash flows'],
            'npv' => ['label' => 'NPV'],
            'investment' => ['label' => 'Investment'],
            'irr' => ['label' => 'IRR'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PI = Σ CFₜ ÷ (1 + r)^t ÷ I₀</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
