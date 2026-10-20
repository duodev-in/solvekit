<x-calc.page
    title="Matrix Trace Calculator - SolveKit"
    description="Free matrix trace calculator: the sum of the diagonal, equal to the sum of the eigenvalues."
    lede="Find the trace."
    about="The trace is the sum of the main diagonal: tr A = Σ aᵢᵢ. It equals the sum of the eigenvalues and satisfies tr(AB) = tr(BA)."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'trace']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the trace of the example matrix?', 'answer' => '5.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="2 1 1
1 3 2
1 0 0" rows="4" />

    <x-calc.result label="Trace" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 1
1 3 2
1 0 0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'eigensum' => ['label' => 'Eigenvalue check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tr A = Σ aᵢᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
