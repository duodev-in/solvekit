<x-calc.page
    title="Column Space Calculator - SolveKit"
    description="Free column space calculator: a basis for the column space (range) from the pivot columns."
    lede="Find the column space."
    about="The column space is every combination of A's columns: all b for which Ax = b has a solution. The pivot columns of the original matrix form a basis; its dimension is the rank. Also known as range of a matrix calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'column']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is a basis for the column space of [[1, 2, 3], [2, 4, 6], [1, 1, 1]]?', 'answer' => '(1, 2, 1), (2, 4, 1).'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
2 4 6
1 1 1" rows="4" />

    <x-calc.result label="Column space basis" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2 3
2 4 6
1 1 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'rank' => ['label' => 'Rank'],
            'pivots' => ['label' => 'Pivot columns'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>col A = span of the pivot columns</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
