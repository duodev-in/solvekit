<x-calc.page
    title="Financial Leverage Ratio Calculator - SolveKit"
    description="Free Financial Leverage Ratio Calculator: leverage = total assets ÷ equity. The equity multiplier shows how much of the assets are financed per dollar of equity; it is a DuPont component."
    lede="Work out the equity multiplier from total assets and shareholders' equity."
    about="The equity multiplier shows how much of the assets are financed per dollar of equity; it is a DuPont component. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'financial_leverage_ratio', 'fields' => ['assets', 'equity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total assets, Shareholders\' equity.'],
        ['name' => 'Read the result', 'text' => 'The equity multiplier appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the equity multiplier?', 'answer' => 'Leverage = total assets ÷ equity.'],
        ['question' => 'What is the equity multiplier for total assets $1,000,000, shareholders\' equity $400,000?', 'answer' => '2.5×.'],
        ['question' => 'And for total assets $250,000, shareholders\' equity $200,000?', 'answer' => '1.25×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Higher means more debt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="assets" label="Total assets" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="equity" label="Shareholders' equity" value="400000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Equity multiplier" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['assets' => 1000000, 'equity' => 400000],
        'Example B' => ['assets' => 250000, 'equity' => 200000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>leverage = total assets ÷ equity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
