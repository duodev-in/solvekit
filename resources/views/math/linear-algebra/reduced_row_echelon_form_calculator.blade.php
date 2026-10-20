<x-calc.page
    title="(Reduced) Row Echelon Form Calculator - SolveKit"
    description="Free RREF calculator: row-reduce a matrix to reduced row echelon form with every row operation, exactly."
    lede="Row-reduce a matrix."
    about="Row echelon form has zeros below each pivot; reduced row echelon form also makes each pivot 1 with zeros above it. The RREF of a matrix is unique and reveals its rank, pivots and the solutions of linear systems. Also known as row echelon form calculator and RREF calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'rref']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the RREF of [[1, 2, 3], [2, 4, 6], [1, 1, 1]]?', 'answer' => 'See the grid: rank 2.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
2 4 6
1 1 1" rows="4" />

    <x-calc.result label="RREF" />

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
            'rank' => ['label' => 'Rank'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>row operations</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
