<x-calc.page
    title="Pivot Point Calculator - SolveKit"
    description="Free pivot point calculator: classic (floor), Fibonacci, Woodie and Camarilla pivots with support and resistance levels from the previous high, low and close."
    lede="Calculate pivot points."
    about="Classic: PP = (H + L + C) ÷ 3, R1 = 2PP − L, S1 = 2PP − H, R2 = PP + (H − L), S2 = PP − (H − L). Fibonacci pivots use 38.2%, 61.8% and 100% of the range; Woodie weights the close twice; Camarilla uses the close ± range × 1.1 ÷ 12, 6, 4, 2. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'pivots', 'fields' => ['high', 'low', 'close', 'method']]"
    :how-to="[
        ['name' => 'Enter the previous period', 'text' => 'High, low and close.'],
        ['name' => 'Choose the method', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the classic pivots for H 4,520, L 4,460, C 4,505?', 'answer' => 'PP 4,495, R1 4,530, S1 4,470.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="high" label="Previous high" value="4520" step="0.01" suffix="$" />
        <x-calc.field name="low" label="Previous low" value="4460" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="close" label="Previous close" value="4505" step="0.01" suffix="$" />
        <x-calc.select name="method" label="Method" :options="['classic' => 'Classic', 'fibonacci' => 'Fibonacci', 'woodie' => 'Woodie', 'camarilla' => 'Camarilla']" selected="classic" />
    </div>

    <x-calc.result label="Pivot point" />

    <x-calc.options :decimals="false" :examples="[
        'Classic' => ['high' => 4520, 'low' => 4460, 'close' => 4505, 'method' => 'classic'],
        'Camarilla' => ['high' => 4520, 'low' => 4460, 'close' => 4505, 'method' => 'camarilla'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r1' => ['label' => 'R1'],
            's1' => ['label' => 'S1'],
            'range' => ['label' => 'Range'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.quick-ref heading="Levels" name="levels" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PP = (H + L + C) ÷ 3</li>
            <li>R1 = 2PP − L, S1 = 2PP − H</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
