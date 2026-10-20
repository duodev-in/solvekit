<x-calc.page
    title="Condition Number Calculator - SolveKit"
    description="Free condition number calculator: κ₂(A) = σmax ÷ σmin, and κ₁, κ∞, with what it means for accuracy."
    lede="Find the condition number."
    about="The condition number says how much errors in b can grow when solving Ax = b: roughly log₁₀ κ digits are lost. κ = 1 is perfect (orthogonal matrices); a singular matrix has κ = ∞."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'cond']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the condition number of [[1, 2], [3, 4]]?', 'answer' => '14.93303437.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
3 4" rows="4" />

    <x-calc.result label="Condition number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
3 4'],
        'Hilbert' => ['a' => '1 1/2 1/3
1/2 1/3 1/4
1/3 1/4 1/5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'norms' => ['label' => 'Norms'],
            'other' => ['label' => 'Other condition numbers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>κ₂ = σmax ÷ σmin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
