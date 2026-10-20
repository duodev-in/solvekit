<x-calc.page
    title="Inverse Variation Calculator - SolveKit"
    description="Free inverse variation calculator: find k in y = k/x from one pair and predict y for a new x."
    lede="Solve an inverse variation."
    about="y varies inversely with x when y = k/x: doubling x halves y, and xy = k stays constant. The graph is a hyperbola. Example: speed and travel time over a fixed distance."
    :calc="['engine' => 'mt-algebra', 'tool' => 'variation', 'fields' => ['x1', 'y1', 'x2'], 'kind' => 'inverse']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'If y = 10 when x = 4, what is y when x = 8?', 'answer' => 'y = 5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="x1" label="Known x" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="Known y" value="10" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="New x" value="8" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="New y" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '4', 'y1' => '10', 'x2' => '8'],
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
            <li>y = k/x</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
