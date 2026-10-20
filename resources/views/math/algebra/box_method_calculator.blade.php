<x-calc.page
    title="Box Method Calculator - SolveKit"
    description="Free box method calculator: multiply polynomials using the box (area model) with every partial product in a grid."
    lede="Multiply with the box method."
    about="In the box method the terms of one polynomial label the rows and the other the columns; each cell holds a product, and adding the cells (combining like terms) gives the answer. It keeps track of every term when FOIL is not enough."
    :calc="['engine' => 'mt-algebra', 'tool' => 'poly_arith', 'fields' => ['p1', 'p2'], 'op' => '*', 'box' => true]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Multiply (x² + 2x + 1)(x − 3).', 'answer' => 'x³ − x² − 5x − 3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="First polynomial" value="x^2 + 2x + 1" type="text" inputmode="text" />
        <x-calc.field name="p2" label="Second polynomial" value="x - 3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => 'x^2 + 2x + 1', 'p2' => 'x - 3'],
        'Binomials' => ['p1' => '3x - 2', 'p2' => '2x + 5'],
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
