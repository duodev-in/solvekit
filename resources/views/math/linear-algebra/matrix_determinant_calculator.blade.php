<x-calc.page
    title="Matrix Determinant Calculator - SolveKit"
    description="Free determinant calculator: det A exactly for square matrices up to 8 × 8, with cofactor expansion for small ones."
    lede="Find the determinant."
    about="The determinant tells whether a square matrix is invertible (det ≠ 0) and how it scales area or volume. 2 × 2: ad − bc. Larger matrices are reduced exactly with fraction-free elimination."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'det']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the determinant of the example matrix?', 'answer' => '−1.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="2 1 1
1 3 2
1 0 0" rows="4" />

    <x-calc.result label="det A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 1
1 3 2
1 0 0'],
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
            <li>det A = Σ (−1)^(i+j) aᵢⱼ Mᵢⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
