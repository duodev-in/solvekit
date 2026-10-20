<x-calc.page
    title="Synthetic Division Calculator - SolveKit"
    description="Free synthetic division calculator: divide a polynomial by x − c with the synthetic division table, quotient and remainder."
    lede="Use synthetic division."
    about="Synthetic division is a shortcut for dividing by x − c using only coefficients: bring down the first, multiply by c, add to the next, repeat. The last number is the remainder, which equals P(c) by the remainder theorem."
    :calc="['engine' => 'mt-algebra', 'tool' => 'divide', 'fields' => ['p1', 'p2'], 'synthetic' => true]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Divide x³ − 2x² − 4 by x − 3 synthetically.', 'answer' => 'x² + x + 3 remainder 5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="Polynomial" value="x^3 - 2x^2 - 4" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Divisor x − c" value="x - 3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Quotient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^3 - 2x^2 - 4', 'p2' => 'x - 3'],
        'Root' => ['p1' => 'x^3 - 7x + 6', 'p2' => 'x + 3'],
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
            <li>Ruffini's rule</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
