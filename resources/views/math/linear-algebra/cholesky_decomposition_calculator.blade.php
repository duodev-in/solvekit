<x-calc.page
    title="Cholesky Decomposition Calculator - SolveKit"
    description="Free Cholesky decomposition calculator: A = LLᵀ for symmetric positive definite matrices."
    lede="Factor A = LLᵀ."
    about="A symmetric positive definite matrix factors as LLᵀ with L lower triangular and positive diagonal. It is twice as fast as LU and fails exactly when A is not positive definite, making it a test too."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'cholesky']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Factor [[4, 2], [2, 3]].', 'answer' => 'See L in the grid; det A = (product of the diagonal of L)² = 8.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="4 2
2 3" rows="4" />

    <x-calc.result label="Cholesky" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '4 2
2 3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'check' => ['label' => 'Check'],
            'det' => ['label' => 'Determinant'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = LLᵀ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
