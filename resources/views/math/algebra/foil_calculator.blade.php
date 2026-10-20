<x-calc.page
    title="FOIL Calculator - SolveKit"
    description="Free FOIL calculator: multiply two binomials with First, Outer, Inner, Last, and combine like terms."
    lede="Multiply binomials with FOIL."
    about="FOIL lists the four products when multiplying (a + b)(c + d): First ac, Outer ad, Inner bc and Last bd. (2x + 3)(x − 5) = 2x² − 10x + 3x − 15 = 2x² − 7x − 15."
    :calc="['engine' => 'mt-algebra', 'tool' => 'poly_arith', 'fields' => ['p1', 'p2'], 'op' => '*', 'foil' => true]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Expand (2x + 3)(x − 5).', 'answer' => '2x² − 7x − 15.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="First polynomial" value="2x + 3" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Second polynomial" value="x − 5" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '2x + 3', 'p2' => 'x - 5'],
        'Squares' => ['p1' => 'x + 4', 'p2' => 'x - 4'],
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
