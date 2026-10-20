<x-calc.page
    title="Graphing Quadratic Inequalities Calculator - SolveKit"
    description="Free quadratic inequality calculator: solve ax² + bx + c > 0 (or <, ≥, ≤) with the roots, sign chart, graph and number line."
    lede="Solve a quadratic inequality."
    about="Find the roots of the quadratic, which split the number line into intervals, then test the sign in each. For x² − x − 6 > 0 the roots −2 and 3 give x < −2 or x > 3, where the parabola is above the axis."
    :calc="['engine' => 'mt-algebra', 'tool' => 'quad_ineq', 'fields' => ['ineq']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve x² − x − 6 > 0.', 'answer' => '(−∞, −2) ∪ (3, ∞).'],
    ]"
>
    <x-calc.field name="ineq" label="Inequality" value="x^2 - x - 6 > 0" type="text" inputmode="text" />

    <x-calc.result label="Solution set" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ineq' => 'x^2 - x - 6 > 0'],
        'Between' => ['ineq' => '2x^2 + 3x - 2 <= 0'],
        'Never' => ['ineq' => 'x^2 + 1 < 0'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Number line" name="line" />
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'interval' => ['label' => 'Interval notation'],
            'builder' => ['label' => 'Set-builder notation'],
            'roots' => ['label' => 'Roots'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sign chart</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
