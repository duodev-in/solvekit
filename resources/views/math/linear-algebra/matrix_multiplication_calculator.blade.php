<x-calc.page
    title="Matrix Multiplication Calculator - SolveKit"
    description="Free matrix multiplication calculator: AB for compatible matrices, with each entry as a row-by-column dot product."
    lede="Multiply matrices."
    about="An m × n matrix times an n × p matrix is m × p: entry (i, j) is row i of A dotted with column j of B. In general AB ≠ BA."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a', 'b'], 'op' => 'mul']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What size is a 3 × 3 matrix times a 3 × 2 matrix?', 'answer' => '3 × 2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Matrix A" value="2 1 1
1 3 2
1 0 0" rows="4" />
        <x-calc.textarea name="b" label="Matrix B" value="1 2
3 4
5 6" rows="4" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 1
1 3 2
1 0 0', 'b' => '1 2
3 4
5 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'commute' => ['label' => 'Commutes?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(AB)ᵢⱼ = Σₖ aᵢₖbₖⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
