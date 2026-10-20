<x-calc.page
    title="Direct Variation Calculator - SolveKit"
    description="Free direct variation calculator: find the constant k in y = kx from one pair and predict y for a new x."
    lede="Solve a direct variation."
    about="y varies directly with x when y = kx for a constant k: doubling x doubles y. From one pair, k = y ÷ x; then y for any x follows. The graph is a line through the origin."
    :calc="['engine' => 'mt-algebra', 'tool' => 'variation', 'fields' => ['x1', 'y1', 'x2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'If y = 10 when x = 4, what is y when x = 6?', 'answer' => 'y = 15.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="x1" label="Known x" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="Known y" value="10" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="New x" value="6" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="New y" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '4', 'y1' => '10', 'x2' => '6'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'Constant k'],
            'equation' => ['label' => 'Equation'],
            'decimal' => ['label' => 'Decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>y = kx</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
