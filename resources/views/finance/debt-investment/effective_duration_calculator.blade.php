<x-calc.page
    title="Effective Duration Calculator - SolveKit"
    description="Free effective duration calculator: duration and convexity from prices after a yield shift down and up, for bonds with embedded options."
    lede="Calculate effective duration from shocked prices."
    about="Effective duration = (P₋ − P₊) ÷ (2 P₀ Δy) and effective convexity = (P₋ + P₊ − 2P₀) ÷ (P₀ Δy²), where P₋ and P₊ are prices after yields fall and rise by Δy. Use them for callable bonds and mortgage-backed securities, whose cash flows change with rates. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'effective_duration', 'fields' => ['price', 'down', 'up', 'shift']]"
    :how-to="[
        ['name' => 'Enter the current price', 'text' => ''],
        ['name' => 'Enter prices after a shift down and up', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the effective duration for prices 102.5 and 97.7 around 100 with a 0.5% shift?', 'answer' => '4.8.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price now" value="100" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Price if yields fall" value="102.5" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="up" label="Price if yields rise" value="97.7" step="0.01" suffix="$" />
        <x-calc.field name="shift" label="Yield shift" value="0.5" min="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Effective duration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 100, 'down' => 102.5, 'up' => 97.7, 'shift' => 0.5],
        'Callable' => ['price' => 101, 'down' => 102, 'up' => 98.6, 'shift' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'convexity' => ['label' => 'Effective convexity'],
            'change' => ['label' => 'Change for +1%'],
            'dv01' => ['label' => 'DV01'],
            'shift' => ['label' => 'Shift'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D_eff = (P₋ − P₊) ÷ (2 P₀ Δy)</li>
            <li>C_eff = (P₋ + P₊ − 2P₀) ÷ (P₀ Δy²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
