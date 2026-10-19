<x-calc.page
    title="Levered Free Cash Flow Calculator - SolveKit"
    description="Free Levered Free Cash Flow Calculator: LFCF = EBITDA − ΔNWC − capex − debt payments. Levered free cash flow is what is left for shareholders after debt obligations."
    lede="Work out the levered free cash flow from your figures."
    about="Levered free cash flow is what is left for shareholders after debt obligations. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'levered_free_cash_flow', 'fields' => ['ebitda', 'nwc', 'capex', 'debt']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBITDA, Increase in net working capital, Capital expenditures, Mandatory debt payments (interest + principal).'],
        ['name' => 'Read the result', 'text' => 'The levered free cash flow appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the levered free cash flow?', 'answer' => 'LFCF = EBITDA − ΔNWC − capex − debt payments.'],
        ['question' => 'What is the levered free cash flow for EBITDA $1,000,000, increase in net working capital $50,000, capital expenditures $250,000, mandatory debt payments $300,000?', 'answer' => '$400,000.00.'],
        ['question' => 'And for EBITDA $350,000, increase in net working capital $20,000, capital expenditures $120,000, mandatory debt payments $180,000?', 'answer' => '$30,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Taxes paid should also be deducted if not in your EBITDA figure.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebitda" label="EBITDA" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="nwc" label="Increase in net working capital" value="50000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="capex" label="Capital expenditures" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="debt" label="Mandatory debt payments (interest + principal)" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Levered free cash flow" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebitda' => 1000000, 'nwc' => 50000, 'capex' => 250000, 'debt' => 300000],
        'Example B' => ['ebitda' => 350000, 'nwc' => 20000, 'capex' => 120000, 'debt' => 180000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LFCF = EBITDA − ΔNWC − capex − debt payments</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
