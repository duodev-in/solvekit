<x-calc.page
    title="Cofactor Expansion Calculator - SolveKit"
    description="Free cofactor (Laplace) expansion calculator: the determinant expanded along the first row, term by term."
    lede="Expand a determinant by cofactors."
    about="Laplace expansion along row 1: det A = Σⱼ (−1)^(1+j) a₁ⱼ det(M₁ⱼ), where M₁ⱼ deletes row 1 and column j. Each smaller determinant can be expanded again. Also known as Laplace expansion calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'expansion']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Expand det of [[1, 2, 3], [4, 5, 6], [7, 8, 10]].', 'answer' => '−3.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
4 5 6
7 8 10" rows="4" />

    <x-calc.result label="det A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2 3
4 5 6
7 8 10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'inverse' => ['label' => 'Inverse'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>det A = Σ (−1)^(1+j) a₁ⱼ det M₁ⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
