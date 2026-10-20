<x-calc.page
    title="Generic Rectangle Calculator - SolveKit"
    description="Free generic rectangle calculator: multiply polynomials with a generic rectangle (area model) grid."
    lede="Multiply with a generic rectangle."
    about="A generic rectangle is the box method drawn as a rectangle whose side lengths are the polynomials; its area pieces are the partial products. It also works backwards for factoring."
    :calc="['engine' => 'mt-algebra', 'tool' => 'poly_arith', 'fields' => ['p1', 'p2'], 'op' => '*', 'box' => true]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Use a generic rectangle for (2x − 1)(x² + 3x + 4).', 'answer' => '2x³ + 5x² + 5x − 4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="First polynomial" value="2x - 1" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Second polynomial" value="x^2 + 3x + 4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '2x - 1', 'p2' => 'x^2 + 3x + 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'degree' => ['label' => 'Degree'],
            'terms' => ['label' => 'Terms'],
            'factored' => ['label' => 'Factored form'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Box" name="box" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>area model</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
