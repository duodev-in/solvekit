<x-calc.page
    title="Intrinsic Value Calculator - SolveKit"
    description="Free intrinsic value calculator: value per share from discounted free cash flow to equity, with terminal value and margin of safety."
    lede="Estimate a share's intrinsic value."
    about="Free cash flow to equity per share is projected at a growth rate, discounted at the cost of equity, plus a terminal value growing at a long-run rate. The answer is very sensitive to the rates: try several. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'intrinsic', 'fields' => ['fcf', 'growth', 'years', 'rate', 'terminal', 'price', 'eps']]"
    :how-to="[
        ['name' => 'Enter cash flow and growth', 'text' => ''],
        ['name' => 'Enter discount and terminal rates', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a share with $5 of FCF growing 10% for 10 years worth at 9%?', 'answer' => '$138.98; 35.24% margin of safety at $90.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fcf" label="Free cash flow per share now" value="5" step="0.01" suffix="$" />
        <x-calc.field name="growth" label="Growth" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Growth years" value="10" min="0" step="1" suffix="years" />
        <x-calc.field name="rate" label="Discount rate" value="9" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="terminal" label="Terminal growth" value="2.5" step="any" suffix="%" />
        <x-calc.field name="price" label="Share price (optional)" value="90" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="eps" label="EPS (optional)" value="6" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Intrinsic value per share" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fcf' => 5, 'growth' => 10, 'years' => 10, 'rate' => 9, 'terminal' => 2.5, 'price' => 90, 'eps' => 6],
        'Slow growth' => ['fcf' => 5, 'growth' => 4, 'years' => 10, 'rate' => 9, 'terminal' => 2, 'price' => 90, 'eps' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'terminal' => ['label' => 'PV of terminal value'],
            'share' => ['label' => 'Terminal share'],
            'mos' => ['label' => 'Margin of safety'],
            'pe' => ['label' => 'Implied P/E'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = Σ FCFₜ ÷ (1 + r)^t + TV ÷ (1 + r)^n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
