<x-calc.page
    title="Gauss-Jordan Elimination Calculator - SolveKit"
    description="Free Gauss-Jordan elimination calculator: row-reduce an augmented matrix [A | b] to read off the solution."
    lede="Solve with Gauss-Jordan elimination."
    about="Gauss–Jordan elimination uses row swaps, scaling and adding multiples of rows until the matrix is in reduced row echelon form. For an augmented matrix the last column then holds the solution."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'rref']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Solve 2x + y − z = 8, −3x − y + 2z = −11, −2x + y + 2z = −3.', 'answer' => 'The last column of the RREF gives x = 2, y = 3, z = −1.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="2 1 -1 8
-3 -1 2 -11
-2 1 2 -3" rows="4" />

    <x-calc.result label="RREF" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 -1 8
-3 -1 2 -11
-2 1 2 -3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'pivots' => ['label' => 'Pivot columns'],
            'rank' => ['label' => 'Rank'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>[A | b] → RREF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
