<x-calc.page
    title="Pseudoinverse Calculator - SolveKit"
    description="Free Moore–Penrose pseudoinverse calculator: A⁺ for any matrix, from the SVD."
    lede="Find the pseudoinverse."
    about="The pseudoinverse A⁺ generalises the inverse to singular and rectangular matrices: x = A⁺b is the least squares solution of smallest length. For invertible A, A⁺ = A⁻¹. Also known as Moore-Penrose inverse calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'pinv']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the pseudoinverse of [[1, 2], [2, 4]]?', 'answer' => 'See the grid.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
2 4" rows="4" />

    <x-calc.result label="A⁺" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
2 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'check' => ['label' => 'Check'],
            'inverse' => ['label' => 'Inverse'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A⁺ = VΣ⁺Uᵀ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
