<x-calc.page
    title="Unlevered Free Cash Flow Calculator - SolveKit"
    description="Free Unlevered Free Cash Flow Calculator: UFCF = EBITDA − taxes − capex − ΔNWC. Unlevered free cash flow is cash before any debt payments, used in DCF valuation."
    lede="Work out the unlevered free cash flow from your figures."
    about="Unlevered free cash flow is cash before any debt payments, used in DCF valuation. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'unlevered_free_cash_flow', 'fields' => ['ebitda', 'taxes', 'capex', 'nwc']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBITDA, Taxes on EBIT, Capital expenditures, Increase in net working capital.'],
        ['name' => 'Read the result', 'text' => 'The unlevered free cash flow appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the unlevered free cash flow?', 'answer' => 'UFCF = EBITDA − taxes − capex − ΔNWC.'],
        ['question' => 'What is the unlevered free cash flow for EBITDA $1,000,000, taxes on EBIT $150,000, capital expenditures $250,000, increase in net working capital $50,000?', 'answer' => '$550,000.00.'],
        ['question' => 'And for EBITDA $420,000, taxes on EBIT $70,000, capital expenditures $110,000, increase in net working capital $20,000?', 'answer' => '$220,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Discount it at the WACC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebitda" label="EBITDA" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="taxes" label="Taxes on EBIT" value="150000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="capex" label="Capital expenditures" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="nwc" label="Increase in net working capital" value="50000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Unlevered free cash flow" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebitda' => 1000000, 'taxes' => 150000, 'capex' => 250000, 'nwc' => 50000],
        'Example B' => ['ebitda' => 420000, 'taxes' => 70000, 'capex' => 110000, 'nwc' => 20000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>UFCF = EBITDA − taxes − capex − ΔNWC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
