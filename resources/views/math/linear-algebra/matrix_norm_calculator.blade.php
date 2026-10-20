<x-calc.page
    title="Matrix Norm Calculator - SolveKit"
    description="Free matrix norm calculator: Frobenius, 1-norm, ∞-norm, spectral 2-norm and max norm."
    lede="Find matrix norms."
    about="Matrix norms measure size: ‖A‖₁ is the largest column sum, ‖A‖∞ the largest row sum, ‖A‖₂ the largest singular value and the Frobenius norm √(Σ aᵢⱼ²)."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'norm']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the Frobenius norm of [[1, 2], [3, 4]]?', 'answer' => '5.47722557505.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
3 4" rows="4" />

    <x-calc.result label="Norm" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
3 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'norms' => ['label' => 'All norms'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>‖A‖F = √(Σ aᵢⱼ²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
