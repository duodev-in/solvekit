<x-calc.page
    title="Diamond Problem Calculator - SolveKit"
    description="Free diamond problem calculator: find the two numbers with a given product (top) and sum (bottom)."
    lede="Solve a diamond problem."
    about="In a diamond problem the top number is the product and the bottom the sum of the two side numbers. They are the roots of t² − (sum)t + product = 0, which is why diamond problems prepare for factoring."
    :calc="['engine' => 'mt-algebra', 'tool' => 'diamond', 'fields' => ['product', 'sum']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Which numbers multiply to −12 and add to 4?', 'answer' => '−2 and 6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="product" label="Product (top)" value="-12" type="text" inputmode="decimal" />
        <x-calc.field name="sum" label="Sum (bottom)" value="4" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="The two numbers" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['product' => '-12', 'sum' => '4'],
        'Fractions' => ['product' => '1/2', 'sum' => '3/2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equation' => ['label' => 'Equation'],
            'check' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t² − St + P = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
