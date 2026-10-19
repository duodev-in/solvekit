<x-calc.page
    title="Dividend Discount Model Calculator - SolveKit"
    description="Free dividend discount model calculator: intrinsic value of a share by the Gordon growth model or a two-stage model."
    lede="Value a stock from its dividends."
    about="Gordon growth model: value = D₁ ÷ (r − g), where D₁ = D₀(1 + g) is next year's dividend. Two-stage: dividends grow fast for some years, then at a lower rate forever. The model suits mature dividend payers. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'ddm', 'fields' => ['mode', 'dividend', 'rate', 'growth', 'price', 'years', 'terminal']]"
    :how-to="[
        ['name' => 'Choose a model', 'text' => ''],
        ['name' => 'Enter dividend, return and growth', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a stock paying $2.50 worth at 9% with 5% growth?', 'answer' => '$65.63.'],
        ['question' => 'And with 10% growth for 5 years, then 3%?', 'answer' => '$57.77.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Model" :options="['gordon' => 'Gordon growth', 'two' => 'Two-stage']" selected="gordon" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dividend" label="Current dividend (D₀)" value="2.5" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Required return" value="9" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="growth" label="Growth (stage 1)" value="5" step="any" suffix="%" />
        <x-calc.field name="price" label="Share price (optional)" value="60" step="0.01" suffix="$" />
    </div>

    <div data-show-when="mode:two" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="years" label="High-growth years" value="5" min="0" step="1" suffix="years" />
            <x-calc.field name="terminal" label="Long-run growth" value="3" step="any" suffix="%" />
        </div>
    </div>

    <x-calc.result label="Intrinsic value per share" />

    <x-calc.options :decimals="false" :examples="[
        'Gordon' => ['mode' => 'gordon', 'dividend' => 2.5, 'rate' => 9, 'growth' => 5, 'price' => 60, 'years' => '', 'terminal' => ''],
        'Two-stage' => ['mode' => 'two', 'dividend' => 2.5, 'rate' => 9, 'growth' => 10, 'price' => 60, 'years' => 5, 'terminal' => 3],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:gordon">
            <x-calc.rows heading="Details" :rows="[
                'd1' => ['label' => 'Next dividend (D₁)'],
                'price' => ['label' => 'Price vs value'],
                'implied' => ['label' => 'Implied return'],
            ]" />
        </div>
        <div data-show-when="mode:two" hidden>
            <x-calc.rows heading="Details" :rows="[
                'd1_two' => ['label' => 'Next dividend (D₁)'],
                'terminal' => ['label' => 'Terminal value'],
                'price_two' => ['label' => 'Price vs value'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P₀ = D₁ ÷ (r − g)</li>
            <li>two-stage: Σ Dₜ ÷ (1 + r)^t + Pₙ ÷ (1 + r)^n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
