<x-calc.page
    title="Polar Decomposition Calculator - SolveKit"
    description="Free polar decomposition calculator: A = UP with an orthogonal U (rotation) and a symmetric positive semidefinite P (stretch)."
    lede="Find the polar decomposition."
    about="Like writing a complex number as e^(iθ)r, every square matrix factors as A = UP: a rotation or reflection U times a symmetric stretch P = √(AᵀA)."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'polar']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Decompose [[1, 2], [0, 1]].', 'answer' => 'See P in the grid and U in the details.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
0 1" rows="4" />

    <x-calc.result label="Polar decomposition" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
0 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'U' => ['label' => 'U'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = UP, P = √(AᵀA)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
