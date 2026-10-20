<x-calc.page
    title="Cofactor Matrix Calculator - SolveKit"
    description="Free cofactor matrix calculator: Cᵢⱼ = (−1)^(i+j) det(Mᵢⱼ) for every entry, exactly."
    lede="Find the cofactor matrix."
    about="Each cofactor is a signed minor: delete row i and column j, take the determinant and apply the checkerboard sign (−1)^(i+j). The transpose of the cofactor matrix is the adjugate."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'cofactor']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the cofactor matrix of [[1, 2, 3], [4, 5, 6], [7, 8, 10]]?', 'answer' => 'See the grid.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
4 5 6
7 8 10" rows="4" />

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2 3
4 5 6
7 8 10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'det' => ['label' => 'Determinant'],
            'inverse' => ['label' => 'Inverse'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Cᵢⱼ = (−1)^(i+j) Mᵢⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
