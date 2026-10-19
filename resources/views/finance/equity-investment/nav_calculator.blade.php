<x-calc.page
    title="NAV Calculator — Net Asset Value - SolveKit"
    description="Free NAV Calculator — Net Asset Value: NAV = (assets − liabilities) ÷ units. Net asset value per share is the price at which mutual funds buy and sell their shares."
    lede="Work out the NAV per share from fund assets, liabilities and shares or units outstanding."
    about="Net asset value per share is the price at which mutual funds buy and sell their shares. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'nav', 'fields' => ['assets', 'liabilities', 'units']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Fund assets, Liabilities, Shares or units outstanding.'],
        ['name' => 'Read the result', 'text' => 'The NAV per share appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the NAV per share?', 'answer' => 'NAV = (assets − liabilities) ÷ units.'],
        ['question' => 'What is the NAV per share for fund assets $120,000,000, liabilities $2,000,000, shares or units outstanding 8,000,000?', 'answer' => '$14.75.'],
        ['question' => 'And for fund assets $52,000,000, liabilities $800,000, shares or units outstanding 4,000,000?', 'answer' => '$12.80.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Exchange-traded funds trade near, but not exactly at, NAV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="assets" label="Fund assets" value="120000000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Liabilities" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="units" label="Shares or units outstanding" value="8000000" step="any" />
    </div>

    <x-calc.result label="NAV per share" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['assets' => 120000000, 'liabilities' => 2000000, 'units' => 8000000],
        'Example B' => ['assets' => 52000000, 'liabilities' => 800000, 'units' => 4000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NAV = (assets − liabilities) ÷ units</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
