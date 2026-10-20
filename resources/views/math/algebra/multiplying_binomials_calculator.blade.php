<x-calc.page
    title="Multiplying Binomials Calculator - SolveKit"
    description="Free multiplying binomials calculator: (a + b)(c + d) expanded with the FOIL steps."
    lede="Multiply two binomials."
    about="Multiplying two binomials gives four products (FOIL) that often combine into three terms: (x + 7)(x − 2) = x² + 5x − 14."
    :calc="['engine' => 'mt-algebra', 'tool' => 'poly_arith', 'fields' => ['p1', 'p2'], 'op' => '*', 'foil' => true]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Expand (x + 7)(x − 2).', 'answer' => 'x² + 5x − 14.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="First polynomial" value="x + 7" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Second polynomial" value="x - 2" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x + 7', 'p2' => 'x - 2'],
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
            <li>(a + b)(c + d) = ac + ad + bc + bd</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
