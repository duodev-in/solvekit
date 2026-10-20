<x-calc.page
    title="Completing the Square Calculator - SolveKit"
    description="Free completing the square calculator: rewrite ax² + bx + c as a(x − h)² + k with the steps, the vertex and the roots."
    lede="Complete the square."
    about="Completing the square rewrites a quadratic in vertex form: take half of the x coefficient, square it, add and subtract it. 2x² + 4x + 5 = 2(x + 1)² + 3, so the vertex is (−1, 3). Solving a(x − h)² + k = 0 gives x = h ± √(−k/a), which is how the quadratic formula is derived."
    :calc="['engine' => 'mt-algebra', 'tool' => 'quadratic', 'fields' => ['a', 'b', 'c'], 'mode' => 'square']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Complete the square for 2x² + 4x + 5.', 'answer' => '2(x + 1)² + 3.'],
        ['question' => 'Does completing the square always work?', 'answer' => 'Yes: every quadratic with a ≠ 0 can be written as a(x − h)² + k. When −k/a is negative the roots are complex.'],
        ['question' => 'How do you solve a quadratic by completing the square?', 'answer' => 'Move the constant, divide by a, add (b/2a)² to both sides, take square roots and solve for x.'],
        ['question' => 'Where else is completing the square used?', 'answer' => 'In integration (∫dx/(x² + 2x + 5) becomes an arctan after completing the square), in circle and parabola equations, and in deriving the normal distribution.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="a" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="b" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c" value="5" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2', 'b' => '4', 'c' => '5'],
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
