<x-calc.page
    title="Multiplying Polynomials Calculator - SolveKit"
    description="Free multiplying polynomials calculator: multiply polynomials of any degree with exact coefficients, term by term."
    lede="Multiply polynomials."
    about="Multiply every term of the first polynomial by every term of the second, then combine like terms. The degree of the product is the sum of the degrees."
    :calc="['engine' => 'mt-algebra', 'tool' => 'poly_arith', 'fields' => ['p1', 'p2'], 'op' => '*']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Multiply (x² − 3x + 2)(2x² + x − 1).', 'answer' => '2x⁴ − 5x³ + 5x − 2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="First polynomial" value="x^2 - 3x + 2" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Second polynomial" value="2x^2 + x - 1" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^2 - 3x + 2', 'p2' => '2x^2 + x - 1'],
        'Fractions' => ['p1' => 'x/2 + 1', 'p2' => '2x - 1/3'],
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
            <li>Σ aᵢbⱼ x^(i+j)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
