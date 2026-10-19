<x-calc.page
    title="FCFF Calculator — Free Cash Flow to Firm - SolveKit"
    description="Free FCFF Calculator — Free Cash Flow to Firm: FCFF = EBIT(1 − t) + D&A − capex − ΔNWC. Free cash flow to the firm is cash available to all capital providers."
    lede="Work out the FCFF from your figures."
    about="Free cash flow to the firm is cash available to all capital providers. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'fcff_calculator_free_cash_flow_to_firm', 'fields' => ['ebit', 'tax', 'da', 'capex', 'nwc']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBIT, Tax rate, Depreciation and amortization, Capital expenditures, Increase in net working capital.'],
        ['name' => 'Read the result', 'text' => 'The FCFF appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the FCFF?', 'answer' => 'FCFF = EBIT(1 − t) + D&A − capex − ΔNWC.'],
        ['question' => 'What is the FCFF for EBIT $1,200,000, tax rate 21%, depreciation and amortization $200,000, capital expenditures $300,000, increase in net working capital $50,000?', 'answer' => '$798,000.00.'],
        ['question' => 'And for EBIT $400,000, tax rate 25%, depreciation and amortization $60,000, capital expenditures $90,000, increase in net working capital $15,000?', 'answer' => '$255,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Discount it at the WACC to value the whole company.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebit" label="EBIT" value="1200000" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="da" label="Depreciation and amortization" value="200000" step="0.01" suffix="$" />
        <x-calc.field name="capex" label="Capital expenditures" value="300000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nwc" label="Increase in net working capital" value="50000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="FCFF" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 1200000, 'tax' => 21, 'da' => 200000, 'capex' => 300000, 'nwc' => 50000],
        'Example B' => ['ebit' => 400000, 'tax' => 25, 'da' => 60000, 'capex' => 90000, 'nwc' => 15000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FCFF = EBIT(1 − t) + D&A − capex − ΔNWC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
