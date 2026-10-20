<x-calc.page
    title="Pascal's Triangle Calculator - SolveKit"
    description="Free Pascal's triangle calculator: generate the rows of Pascal's triangle with exact binomial coefficients."
    lede="Generate Pascal's triangle."
    about="Each entry of Pascal's triangle is the sum of the two above it. Row n lists C(n, 0), …, C(n, n), the coefficients of (a + b)ⁿ, and adds up to 2ⁿ."
    :calc="['engine' => 'mt-seq', 'tool' => 'pascal', 'fields' => ['rows']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the last row of a 10-row Pascal\'s triangle?', 'answer' => '1 9 36 84 126 126 84 36 9 1.'],
    ]"
>
    <x-calc.field name="rows" label="Rows" value="10" min="1" max="40" step="1" />

    <x-calc.result label="Pascal's triangle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rows' => 10],
        'Small' => ['rows' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Sum of last row'],
            'middle' => ['label' => 'Middle entry'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C(n, k) = C(n − 1, k − 1) + C(n − 1, k)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
