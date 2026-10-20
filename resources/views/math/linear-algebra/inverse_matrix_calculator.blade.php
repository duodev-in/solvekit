<x-calc.page
    title="Inverse Matrix Calculator - SolveKit"
    description="Free inverse matrix calculator: A⁻¹ exactly with fractions by Gauss–Jordan elimination of [A | I]."
    lede="Invert a matrix."
    about="A square matrix with det ≠ 0 has an inverse with AA⁻¹ = I. Row-reduce [A | I] to [I | A⁻¹]. For 2 × 2, A⁻¹ = (1/(ad − bc)) [[d, −b], [−c, a]]. Also known as matrix inverse calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'inverse']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the inverse of the example matrix?', 'answer' => 'See the grid (det = −1).'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="2 1 1
1 3 2
1 0 0" rows="4" />

    <x-calc.result label="A⁻¹" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 1
1 3 2
1 0 0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'det' => ['label' => 'Determinant'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>[A | I] → [I | A⁻¹]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
