<x-calc.page
    title="Net Operating Assets Calculator - SolveKit"
    description="Free Net Operating Assets Calculator: NOA = operating assets − operating liabilities. Net operating assets exclude financial assets and debt."
    lede="Work out the net operating assets from operating assets and operating liabilities."
    about="Net operating assets exclude financial assets and debt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_operating_assets', 'fields' => ['opassets', 'opliab']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating assets, Operating liabilities.'],
        ['name' => 'Read the result', 'text' => 'The net operating assets appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net operating assets?', 'answer' => 'NOA = operating assets − operating liabilities.'],
        ['question' => 'What is the net operating assets for operating assets $3,000,000, operating liabilities $1,200,000?', 'answer' => '$1,800,000.00.'],
        ['question' => 'And for operating assets $750,000, operating liabilities $300,000?', 'answer' => '$450,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Used in the accrual ratio and ROIC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="opassets" label="Operating assets" value="3000000" step="0.01" suffix="$" />
        <x-calc.field name="opliab" label="Operating liabilities" value="1200000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net operating assets" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['opassets' => 3000000, 'opliab' => 1200000],
        'Example B' => ['opassets' => 750000, 'opliab' => 300000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NOA = operating assets − operating liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
