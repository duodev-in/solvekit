<x-calc.page
    title="Value at Risk Calculator (VaR) - SolveKit"
    description="Free value at risk calculator: parametric (normal) VaR from volatility, or historical VaR from past returns, with expected shortfall."
    lede="Estimate the loss you would exceed only rarely."
    about="Parametric VaR = value × (z σ √t − μt), with σ the annual volatility, t the horizon in years (trading days ÷ 252) and z from the normal distribution (1.645 at 95%). Historical VaR takes the loss at the matching percentile of past returns. Expected shortfall is the average loss beyond VaR. Real returns have fatter tails than the normal curve. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'var', 'fields' => ['mode', 'value', 'confidence', 'volatility', 'days', 'mean', 'returns']]"
    :how-to="[
        ['name' => 'Enter the portfolio value', 'text' => 'And confidence.'],
        ['name' => 'Choose the method', 'text' => 'Volatility or past returns.'],
    ]"
    :faqs="[
        ['question' => 'What is the 10-day 95% VaR of $1M at 20% volatility?', 'answer' => '$65,532.54.'],
        ['question' => 'And at 99%?', 'answer' => '$92,683.92.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['parametric' => 'Parametric', 'historical' => 'Historical']" selected="parametric" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Portfolio value" value="1000000" step="0.01" suffix="$" />
        <x-calc.select name="confidence" label="Confidence" :options="['90' => '90%', '95' => '95%', '97.5' => '97.5%', '99' => '99%', '99.5' => '99.5%']" selected="95" />
    </div>

    <div data-show-when="mode:parametric">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="volatility" label="Annual volatility" value="20" step="any" suffix="%" />
            <x-calc.field name="days" label="Horizon" value="10" min="1" step="1" suffix="days" />
            <x-calc.field name="mean" label="Expected annual return (optional)" value="0" step="any" suffix="%" />
        </div>
    </div>

    <div data-show-when="mode:historical" hidden>
        <x-calc.textarea name="returns" label="Past returns in % (one per line or comma-separated)" value="-2.1, 0.5, 1.2, -0.8, 0.3, -1.5, 2.0, 0.7, -3.2, 1.1, 0.4, -0.6, 0.9, -1.1, 1.6, -0.2, 0.8, -2.6, 1.3, 0.1" rows="4" />
    </div>

    <x-calc.result label="Value at risk" />

    <x-calc.options :decimals="false" :examples="[
        'Parametric' => ['mode' => 'parametric', 'value' => 1000000, 'confidence' => '95', 'volatility' => 20, 'days' => 10, 'mean' => 0, 'returns' => ''],
        '99%' => ['mode' => 'parametric', 'value' => 1000000, 'confidence' => '99', 'volatility' => 20, 'days' => 10, 'mean' => 0, 'returns' => ''],
        'Historical' => ['mode' => 'historical', 'value' => 500000, 'confidence' => '95', 'volatility' => '', 'days' => '', 'mean' => '', 'returns' => '-2.1, 0.5, 1.2, -0.8, 0.3, -1.5, 2.0, 0.7, -3.2, 1.1, 0.4, -0.6, 0.9, -1.1, 1.6, -0.2, 0.8, -2.6, 1.3, 0.1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'percent' => ['label' => 'As a share of value'],
            'es' => ['label' => 'Expected shortfall'],
            'worst' => ['label' => 'Volatility or worst return'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VaR = V(zσ√t − μt)</li>
            <li>ES = V(σ√t φ(z) ÷ (1 − c) − μt)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
