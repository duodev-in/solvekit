<x-calc.page
    title="Private Savings Calculator - SolveKit"
    description="Free Private Savings Calculator: S_private = Y − T + TR − C. Private saving is income left after taxes and consumption."
    lede="Work out the private saving from your figures."
    about="Private saving is income left after taxes and consumption. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'private_savings', 'fields' => ['income', 'taxes', 'consumption', 'transfers']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'National income (Y), Taxes (T), Consumption (C), Transfers (TR, optional).'],
        ['name' => 'Read the result', 'text' => 'The private saving appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the private saving?', 'answer' => 'S_private = Y − T + TR − C.'],
        ['question' => 'What is the private saving for national income $20,000, taxes $4,000, consumption $14,000, transfers $0?', 'answer' => '$2,000.00.'],
        ['question' => 'And for national income $15,000, taxes $3,000, consumption $11,500, transfers $800?', 'answer' => '$1,300.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'National saving adds public saving (T − G).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="National income (Y)" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="taxes" label="Taxes (T)" value="4000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="consumption" label="Consumption (C)" value="14000" step="0.01" suffix="$" />
        <x-calc.field name="transfers" label="Transfers (TR, optional)" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Private saving" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 20000, 'taxes' => 4000, 'consumption' => 14000, 'transfers' => 0],
        'Example B' => ['income' => 15000, 'taxes' => 3000, 'consumption' => 11500, 'transfers' => 800],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>S_private = Y − T + TR − C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
