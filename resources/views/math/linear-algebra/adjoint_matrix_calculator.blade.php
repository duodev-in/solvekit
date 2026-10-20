<x-calc.page
    title="Adjoint Matrix Calculator - SolveKit"
    description="Free adjoint (adjugate) matrix calculator: adj A = Cᵀ, and A⁻¹ = adj A ÷ det A."
    lede="Find the adjugate matrix."
    about="The adjugate (classical adjoint) is the transpose of the cofactor matrix. It satisfies A · adj A = det(A) I, so A⁻¹ = adj A/det A when det A ≠ 0. Also known as adjugate matrix calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'adjoint']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is adj A for [[1, 2, 3], [4, 5, 6], [7, 8, 10]]?', 'answer' => 'See the grid; det A = −3.'],
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
            <li>adj A = Cᵀ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
