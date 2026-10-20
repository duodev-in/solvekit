<x-calc.page
    title="Perfect Square Trinomial Calculator - SolveKit"
    description="Free perfect square trinomial calculator: check whether ax² + bx + c is a perfect square (b² = 4ac) and factor it."
    lede="Check for a perfect square trinomial."
    about="A perfect square trinomial is the square of a binomial: a²x² ± 2abx + b² = (ax ± b)². Test: b² = 4ac with a and c perfect squares. 4x² − 12x + 9 = (2x − 3)²."
    :calc="['engine' => 'mt-algebra', 'tool' => 'factor', 'fields' => ['p1'], 'perfect' => true]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is 4x² − 12x + 9 a perfect square?', 'answer' => '(2x − 3)²: b² = 4ac.'],
    ]"
>
    <x-calc.field name="p1" label="Trinomial" value="4x^2 - 12x + 9" type="text" inputmode="text" />

    <x-calc.result label="Perfect square?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '4x^2 - 12x + 9'],
        'No' => ['p1' => 'x^2 + 6x + 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'expanded' => ['label' => 'Expanded'],
            'roots' => ['label' => 'Rational roots'],
            'degree' => ['label' => 'Degree'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(ax ± b)² = a²x² ± 2abx + b²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
