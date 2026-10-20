<x-calc.page
    title="Singular Values Calculator - SolveKit"
    description="Free singular values calculator: σᵢ = √(eigenvalues of AᵀA), with the rank and condition number."
    lede="Find the singular values."
    about="The singular values are the square roots of the eigenvalues of AᵀA, listed from largest to smallest. The number of non-zero ones is the rank."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'singular']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What are the singular values of [[1, 2], [2, 4]]?', 'answer' => '5, 0.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
2 4" rows="4" />

    <x-calc.result label="Singular values" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
2 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'U' => ['label' => 'U'],
            'V' => ['label' => 'V'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>σᵢ = √λᵢ(AᵀA)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
