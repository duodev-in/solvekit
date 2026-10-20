<x-calc.page
    title="Adding and Subtracting Polynomials Calculator - SolveKit"
    description="Free adding and subtracting polynomials calculator: combine like terms of two polynomials exactly."
    lede="Add or subtract polynomials."
    about="Add or subtract polynomials by combining like terms (same power of x). When subtracting, change the sign of every term of the second polynomial first: (3x² + 2x − 1) − (x² − 4x + 5) = 2x² + 6x − 6."
    :calc="['engine' => 'mt-algebra', 'tool' => 'poly_arith', 'fields' => ['p1', 'op', 'p2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is (3x² + 2x − 1) − (x² − 4x + 5)?', 'answer' => '2x² + 6x − 6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="p1" label="First polynomial" value="3x^2 + 2x - 1" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−']" selected="-" />
        <x-calc.field name="p2" label="Second polynomial" value="x^2 - 4x + 5" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '3x^2 + 2x - 1', 'op' => '-', 'p2' => 'x^2 - 4x + 5'],
        'Add' => ['p1' => 'x^3 - 2x', 'op' => '+', 'p2' => '4x^2 + 2x + 7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'degree' => ['label' => 'Degree'],
            'terms' => ['label' => 'Terms'],
            'factored' => ['label' => 'Factored form'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>combine like terms</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
