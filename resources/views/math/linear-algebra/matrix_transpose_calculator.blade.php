<x-calc.page
    title="Matrix Transpose Calculator - SolveKit"
    description="Free matrix transpose calculator: Aᵀ swaps rows and columns."
    lede="Transpose a matrix."
    about="The transpose flips a matrix across its diagonal: row i becomes column i. (AB)ᵀ = BᵀAᵀ, and a matrix equal to its transpose is symmetric."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'transpose']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Is the example matrix symmetric?', 'answer' => 'A is not symmetric.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2 3
4 5 6" rows="4" />

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2 3
4 5 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'symmetric' => ['label' => 'Symmetric?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(Aᵀ)ᵢⱼ = aⱼᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
