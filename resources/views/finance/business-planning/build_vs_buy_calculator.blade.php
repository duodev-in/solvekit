<x-calc.page
    title="Build vs. Buy Calculator - SolveKit"
    description="Free build vs buy calculator: total cost of ownership of building in-house or buying (or subscribing), discounted to present value over the years."
    lede="Compare building with buying."
    about="Each option's cost = upfront cost + yearly running costs, discounted at your cost of capital: PV = Σ Cₜ ÷ (1 + r)^t. Include build maintenance (often 15–20% of build cost a year) and the buy option's subscription and integration. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'build_buy', 'fields' => ['build_up', 'build_year', 'buy_up', 'buy_year', 'years', 'rate']]"
    :how-to="[
        ['name' => 'Enter both options\' costs', 'text' => ''],
        ['name' => 'Enter years and rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Over 5 years at 8%, is building for $250,000 + $50,000 a year cheaper than buying at $20,000 + $90,000 a year?', 'answer' => 'Buy: saves $70,291.60 in present value over 5 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="build_up" label="Build: upfront cost" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="build_year" label="Build: yearly cost" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="buy_up" label="Buy: upfront cost" value="20000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="buy_year" label="Buy: yearly cost" value="90000" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years" value="5" min="0" step="1" suffix="years" />
        <x-calc.field name="rate" label="Discount rate" value="8" step="any" suffix="%" />
    </div>

    <x-calc.result label="Lower cost of ownership" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['build_up' => 250000, 'build_year' => 50000, 'buy_up' => 20000, 'buy_year' => 90000, 'years' => 5, 'rate' => 8],
        'Longer horizon' => ['build_up' => 250000, 'build_year' => 50000, 'buy_up' => 20000, 'buy_year' => 90000, 'years' => 10, 'rate' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'build' => ['label' => 'Build (present value)'],
            'buy' => ['label' => 'Buy (present value)'],
            'nominalBuild' => ['label' => 'Build (undiscounted)'],
            'nominalBuy' => ['label' => 'Buy (undiscounted)'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = upfront + Σ yearly ÷ (1 + r)^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
