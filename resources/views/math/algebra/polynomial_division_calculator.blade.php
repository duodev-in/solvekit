<x-calc.page
    title="Polynomial Division Calculator - SolveKit"
    description="Free polynomial long division calculator: quotient and remainder of two polynomials with each division step."
    lede="Divide polynomials."
    about="Polynomial long division repeats: divide the leading terms, multiply the divisor by that term, subtract, and continue with the remainder until its degree is less than the divisor's. P(x) = D(x)Q(x) + R(x)."
    :calc="['engine' => 'mt-algebra', 'tool' => 'divide', 'fields' => ['p1', 'p2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Divide x³ − 2x² − 4 by x − 3.', 'answer' => 'x² + x + 3 + 5/(x − 3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="Dividend" value="x^3 - 2x^2 - 4" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Divisor" value="x - 3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Quotient and remainder" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^3 - 2x^2 - 4', 'p2' => 'x - 3'],
        'Exact' => ['p1' => '2x^3 + 3x^2 - 11x - 6', 'p2' => 'x^2 + x - 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'quotient' => ['label' => 'Quotient'],
            'remainder' => ['label' => 'Remainder'],
            'factor' => ['label' => 'Factor?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = DQ + R</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
