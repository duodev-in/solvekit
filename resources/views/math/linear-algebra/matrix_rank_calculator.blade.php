<x-calc.page
    title="Matrix Rank Calculator - SolveKit"
    description="Free matrix rank calculator: the number of independent rows (pivots), with the nullity and RREF."
    lede="Find the rank of a matrix."
    about="The rank is the number of pivots after row reduction, the dimension of the column (and row) space. Rank + nullity = number of columns."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'rank']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the rank of [[1, 2, 3], [2, 4, 6], [1, 1, 1]]?', 'answer' => '2.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
2 4 6
1 1 1" rows="4" />

    <x-calc.result label="Rank" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2 3
2 4 6
1 1 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'pivots' => ['label' => 'Pivot columns'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rank = number of pivots</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
