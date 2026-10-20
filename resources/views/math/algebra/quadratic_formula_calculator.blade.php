<x-calc.page
    title="Quadratic Formula Calculator - SolveKit"
    description="Free quadratic formula calculator: solve ax² + bx + c = 0 exactly (rational, surd or complex roots), with the discriminant, vertex and graph."
    lede="Solve a quadratic equation."
    about="The quadratic formula x = (−b ± √(b² − 4ac)) ÷ 2a solves every quadratic. The discriminant Δ = b² − 4ac decides the roots: positive gives two real roots, zero one repeated root, negative two complex conjugates. Roots are given exactly, such as 1 ± √2."
    :calc="['engine' => 'mt-algebra', 'tool' => 'quadratic', 'fields' => ['a', 'b', 'c']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve x² − 2x − 1 = 0.', 'answer' => '1 − √2,  1 + √2.'],
        ['question' => 'Solve 2x² + 4x + 5 = 0.', 'answer' => '−1 − (√6/2)i,  −1 + (√6/2)i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="a" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="b" value="-2" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c" value="-1" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1', 'b' => '-2', 'c' => '-1'],
        'Rational' => ['a' => '6', 'b' => '11', 'c' => '-10'],
        'Complex' => ['a' => '2', 'b' => '4', 'c' => '5'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph of y = ax² + bx + c" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'disc' => ['label' => 'Discriminant'],
            'vertex' => ['label' => 'Vertex'],
            'nature' => ['label' => 'Nature of the roots'],
            'sum' => ['label' => 'Sum of roots'],
            'product' => ['label' => 'Product of roots'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x = (−b ± √(b² − 4ac)) ÷ 2a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
