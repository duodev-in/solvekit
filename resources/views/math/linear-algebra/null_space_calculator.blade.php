<x-calc.page
    title="Null Space Calculator - SolveKit"
    description="Free null space calculator: a basis for all solutions of Ax = 0, exactly, and the nullity."
    lede="Find the null space."
    about="The null space (kernel) is every x with Ax = 0. Row-reduce A; each free column gives one basis vector. Its dimension is the nullity = columns − rank. Also known as kernel calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'null']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the null space of [[1, 2, 3], [2, 4, 6], [1, 1, 1]]?', 'answer' => '(1, −2, 1).'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
2 4 6
1 1 1" rows="4" />

    <x-calc.result label="Null space basis" />

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
            <li>Ax = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
