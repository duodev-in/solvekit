<x-calc.page
    title="SVD Calculator - SolveKit"
    description="Free SVD calculator: the singular value decomposition A = UΣVᵀ with U, Σ and V."
    lede="Find the SVD."
    about="Every matrix factors as A = UΣVᵀ with orthogonal U and V and non-negative singular values on the diagonal of Σ. They give the rank, the 2-norm, the condition number and the best low-rank approximations. Also known as singular value decomposition calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'svd']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What are the singular values of [[3, 0], [4, 5]]?', 'answer' => '6.708203932, 2.236067977.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="3 0
4 5" rows="4" />

    <x-calc.result label="Singular values" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3 0
4 5'],
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
            <li>A = UΣVᵀ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
