<x-calc.page
    title="Cubic Equation Calculator - SolveKit"
    description="Free cubic equation calculator: all three roots of ax³ + bx² + cx + d = 0, exact when rational and otherwise to 12 digits, with the discriminant and graph."
    lede="Solve a cubic equation."
    about="Every cubic has three roots counted with multiplicity: three real roots when the discriminant is positive, or one real root and a complex pair when it is negative. Rational roots are found exactly (rational root theorem); the rest come from the quadratic formula or a numerical solution equivalent to Cardano's formula."
    :calc="['engine' => 'mt-algebra', 'tool' => 'cubic', 'fields' => ['a', 'b', 'c', 'd']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve x³ − 6x² + 11x − 6 = 0.', 'answer' => '1,  2,  3.'],
        ['question' => 'Solve x³ = 2.', 'answer' => '−0.629960524947 − 1.09112363597i,  −0.629960524947 + 1.09112363597i,  1.25992104989.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="a" label="a" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="b" value="-6" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c" value="11" type="text" inputmode="decimal" />
        <x-calc.field name="d" label="d" value="-6" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1', 'b' => '-6', 'c' => '11', 'd' => '-6'],
        'Cube root' => ['a' => '1', 'b' => '0', 'c' => '0', 'd' => '-2'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'disc' => ['label' => 'Discriminant'],
            'real' => ['label' => 'Real roots'],
            'complex' => ['label' => 'Complex roots'],
            'factored' => ['label' => 'Factored form'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Δ = 18abcd − 4b³d + b²c² − 4ac³ − 27a²d²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
