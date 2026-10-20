<x-calc.page
    title="Polynomial Roots Calculator - SolveKit"
    description="Free polynomial roots calculator: every real and complex root of a polynomial up to degree 20, exact rational roots and multiplicities."
    lede="Find all roots of a polynomial."
    about="A polynomial of degree n has exactly n roots counting multiplicity (the fundamental theorem of algebra). Rational roots are found exactly; the remaining factor is solved by the quadratic formula or numerically with the Durand–Kerner method and Newton polishing (12 significant digits)."
    :calc="['engine' => 'mt-algebra', 'tool' => 'roots', 'fields' => ['p1']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Find the roots of x⁴ − 5x² + 4.', 'answer' => 'x = −1;  x = 1;  x = −2;  x = 2.'],
        ['question' => 'And x⁵ − x + 1?', 'answer' => '−1.167303978 is the only real root.'],
    ]"
>
    <x-calc.field name="p1" label="Polynomial" value="x^4 - 5x^2 + 4" type="text" inputmode="text" />

    <x-calc.result label="Roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^4 - 5x^2 + 4'],
        'Quintic' => ['p1' => 'x^5 - x + 1'],
        'Repeated' => ['p1' => '(x-1)^3 (x+2)'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'factored' => ['label' => 'Factored form'],
            'real' => ['label' => 'Real roots'],
            'complex' => ['label' => 'Complex roots'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P(x) = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
