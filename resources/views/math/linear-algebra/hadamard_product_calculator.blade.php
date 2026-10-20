<x-calc.page
    title="Hadamard Product Calculator - SolveKit"
    description="Free Hadamard product calculator: the entry-wise product A ∘ B of two same-size matrices."
    lede="Multiply entry by entry."
    about="The Hadamard (Schur) product multiplies matching entries: (A ∘ B)ᵢⱼ = aᵢⱼbᵢⱼ. Unlike the ordinary product it is commutative and needs equal sizes."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a', 'b'], 'op' => 'hadamard']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is [[1, 2], [3, 4]] ∘ [[5, 6], [7, 8]]?', 'answer' => 'The grid shows [[5, 12], [21, 32]].'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Matrix A" value="1 2
3 4" rows="4" />
        <x-calc.textarea name="b" label="Matrix B" value="5 6
7 8" rows="4" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
3 4', 'b' => '5 6
7 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(A ∘ B)ᵢⱼ = aᵢⱼbᵢⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
