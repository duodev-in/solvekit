<x-calc.page
    title="Discounted Cash Flow Calculator (DCF) - SolveKit"
    description="Free DCF calculator: value a business from free cash flow, a growth period, a discount rate and a terminal growth rate, with equity value per share."
    lede="Value a company by discounting its future cash flows."
    about="A two-stage DCF projects free cash flow growing at g for N years, discounts each at r, and adds a terminal value TV = CFₙ(1 + g∞) ÷ (r − g∞) discounted from year N. The result is enterprise value; subtract net debt for equity value. Small changes in r and g∞ move the answer a lot. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'dcf', 'fields' => ['cash', 'growth', 'years', 'rate', 'terminal', 'debt', 'shares']]"
    :how-to="[
        ['name' => 'Enter the cash flow and growth', 'text' => 'For the forecast years.'],
        ['name' => 'Enter the rates', 'text' => 'Discount and terminal growth.'],
    ]"
    :faqs="[
        ['question' => 'What is a business worth with $1M free cash flow growing 10% for 5 years, 9% WACC and 2.5% terminal growth?', 'answer' => '$21,645,294.62; per share $19.65.'],
        ['question' => 'What if the discount rate is 11%?', 'answer' => '$16,391,809.90.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash" label="Free cash flow this year" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="growth" label="Growth during forecast" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Forecast years" value="5" min="0" step="1" suffix="years" />
        <x-calc.field name="rate" label="Discount rate (WACC)" value="9" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="terminal" label="Terminal growth" value="2.5" step="any" suffix="%" />
        <x-calc.field name="debt" label="Net debt (optional)" value="2000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shares" label="Shares outstanding (optional)" value="1000000" min="0" step="1" />
    </div>

    <x-calc.result label="Present value (enterprise value)" />

    <x-calc.options :decimals="false" :examples="[
        'Base case' => ['cash' => 1000000, 'growth' => 10, 'years' => 5, 'rate' => 9, 'terminal' => 2.5, 'debt' => 2000000, 'shares' => 1000000],
        'Higher rate' => ['cash' => 1000000, 'growth' => 10, 'years' => 5, 'rate' => 11, 'terminal' => 2.5, 'debt' => 2000000, 'shares' => 1000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'forecast' => ['label' => 'PV of forecast cash flows'],
            'terminal' => ['label' => 'Terminal value'],
            'equity' => ['label' => 'Equity value'],
            'share' => ['label' => 'Value per share'],
        ]" />
        <x-calc.grid heading="Forecast" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = Σ CF₀(1 + g)^t ÷ (1 + r)^t + TV ÷ (1 + r)^N</li>
            <li>TV = CFₙ(1 + g∞) ÷ (r − g∞)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
