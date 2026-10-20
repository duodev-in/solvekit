<x-calc.page
    title="LU Decomposition Calculator - SolveKit"
    description="Free LU decomposition calculator: A = LU (or PA = LU with row swaps) exactly with fractions."
    lede="Factor A = LU."
    about="LU decomposition records Gaussian elimination: U is the upper triangular result and L holds the multipliers below a unit diagonal. A permutation P is needed when a zero pivot forces a row swap. Solving Ax = b then takes two triangular solves."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'lu']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Factor [[4, 3], [6, 3]].', 'answer' => 'L has multiplier 3/2: ⎡   1  0 ⎤ ⎣ 3/2  1 ⎦.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="4 3
6 3" rows="4" />

    <x-calc.result label="LU" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '4 3
6 3'],
        'Pivot' => ['a' => '0 1
1 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'L' => ['label' => 'L'],
            'P' => ['label' => 'P'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PA = LU</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
