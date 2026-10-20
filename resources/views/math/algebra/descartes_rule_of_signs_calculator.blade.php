<x-calc.page
    title="Descartes' Rule of Signs Calculator - SolveKit"
    description="Free Descartes' rule of signs calculator: the possible numbers of positive and negative real roots of a polynomial."
    lede="Apply Descartes' rule of signs."
    about="The number of positive real roots equals the number of sign changes in the coefficients, or less by an even number. For negative roots, count the sign changes of P(−x). The actual counts are shown for comparison."
    :calc="['engine' => 'mt-algebra', 'tool' => 'descartes', 'fields' => ['p1']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many positive roots can x³ − 3x² + x + 5 have?', 'answer' => 'Positive: 2, 0;  negative: 1.'],
    ]"
>
    <x-calc.field name="p1" label="Polynomial" value="x^3 - 3x^2 + x + 5" type="text" inputmode="text" />

    <x-calc.result label="Possible real roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^3 - 3x^2 + x + 5'],
        'Quartic' => ['p1' => 'x^4 - x^3 - 7x^2 + x + 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pos' => ['label' => 'Sign changes in P(x)'],
            'neg' => ['label' => 'Sign changes in P(−x)'],
            'actual' => ['label' => 'Actual'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sign changes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
