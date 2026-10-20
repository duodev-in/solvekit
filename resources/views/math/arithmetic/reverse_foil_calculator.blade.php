<x-calc.page
    title="Reverse FOIL Calculator - SolveKit"
    description="Free reverse FOIL calculator: factor a quadratic trinomial back into two binomials."
    lede="Undo FOIL: factor a trinomial."
    about="Reverse FOIL turns ax² + bx + c back into (px + q)(rx + s): the First terms multiply to ax², the Last to c, and Outer + Inner give bx. x² − 5x + 6 = (x − 2)(x − 3)."
    :calc="['engine' => 'mt-algebra', 'tool' => 'factor', 'fields' => ['p1']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Factor x² − 5x + 6.', 'answer' => '(x − 2)(x − 3).'],
    ]"
>
    <x-calc.field name="p1" label="Trinomial" value="x^2 - 5x + 6" type="text" inputmode="text" />

    <x-calc.result label="Factored form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^2 - 5x + 6'],
        'Leading coefficient' => ['p1' => '3x^2 + 10x - 8'],
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
            <li>(px + q)(rx + s)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
