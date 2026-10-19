<x-calc.page
    title="AFFO Calculator — Adjusted Funds From Operations - SolveKit"
    description="Free AFFO Calculator — Adjusted Funds From Operations: AFFO = FFO − recurring capex − straight-line rent. Adjusted funds from operations approximates cash a REIT can pay out."
    lede="Work out the AFFO from funds from operations, recurring capital expenditures and straight-line rent adjustment."
    about="Adjusted funds from operations approximates cash a REIT can pay out. Definitions vary by company. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'affo_calculator_adjusted_funds_from_operations', 'fields' => ['ffo', 'capex', 'straight']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Funds from operations, Recurring capital expenditures, Straight-line rent adjustment.'],
        ['name' => 'Read the result', 'text' => 'The AFFO appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the AFFO?', 'answer' => 'AFFO = FFO − recurring capex − straight-line rent.'],
        ['question' => 'What is the AFFO for funds from operations $3,000,000, recurring capital expenditures $400,000, straight-line rent adjustment $100,000?', 'answer' => '$2,500,000.00.'],
        ['question' => 'And for funds from operations $850,000, recurring capital expenditures $120,000, straight-line rent adjustment $15,000?', 'answer' => '$715,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Payout ratios are often measured against AFFO.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ffo" label="Funds from operations" value="3000000" step="0.01" suffix="$" />
        <x-calc.field name="capex" label="Recurring capital expenditures" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="straight" label="Straight-line rent adjustment" value="100000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="AFFO" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ffo' => 3000000, 'capex' => 400000, 'straight' => 100000],
        'Example B' => ['ffo' => 850000, 'capex' => 120000, 'straight' => 15000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AFFO = FFO − recurring capex − straight-line rent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
