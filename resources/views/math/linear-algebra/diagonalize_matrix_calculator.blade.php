<x-calc.page
    title="Diagonalize Matrix Calculator - SolveKit"
    description="Free matrix diagonalization calculator: A = PDP⁻¹ with eigenvectors in P and eigenvalues in D, or why it fails."
    lede="Diagonalize a matrix."
    about="A is diagonalizable when it has n independent eigenvectors: then A = PDP⁻¹ with the eigenvectors as the columns of P. Repeated eigenvalues with too few eigenvectors (defective matrices) and complex eigenvalues prevent it over the reals."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'diagonalize']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Is [[4, 1], [2, 3]] diagonalizable?', 'answer' => 'Yes, A = PDP⁻¹.'],
        ['question' => 'And [[1, 1], [0, 1]]?', 'answer' => 'No (defective: too few eigenvectors).'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="4 1
2 3" rows="4" />

    <x-calc.result label="Diagonalizable?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '4 1
2 3'],
        'Defective' => ['a' => '1 1
0 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'eigenvalues' => ['label' => 'Eigenvalues'],
            'vectors' => ['label' => 'Eigenvectors'],
            'P' => ['label' => 'P'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = PDP⁻¹</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
