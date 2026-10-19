<x-calc.page
    title="Free Cash Flow Calculator - SolveKit"
    description="Free Free Cash Flow Calculator: FCF = operating cash flow − capital expenditures. Free cash flow is cash left after investing in the business, available for debt, dividends and buybacks."
    lede="Work out the free cash flow from operating cash flow and capital expenditures."
    about="Free cash flow is cash left after investing in the business, available for debt, dividends and buybacks. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'free_cash_flow', 'fields' => ['ocf', 'capex']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating cash flow, Capital expenditures.'],
        ['name' => 'Read the result', 'text' => 'The free cash flow appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the free cash flow?', 'answer' => 'FCF = operating cash flow − capital expenditures.'],
        ['question' => 'What is the free cash flow for operating cash flow $900,000, capital expenditures $300,000?', 'answer' => '$600,000.00.'],
        ['question' => 'And for operating cash flow $150,000, capital expenditures $210,000?', 'answer' => '−$60,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative FCF is normal for fast-growing firms.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ocf" label="Operating cash flow" value="900000" step="0.01" suffix="$" />
        <x-calc.field name="capex" label="Capital expenditures" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Free cash flow" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ocf' => 900000, 'capex' => 300000],
        'Example B' => ['ocf' => 150000, 'capex' => 210000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FCF = operating cash flow − capital expenditures</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
