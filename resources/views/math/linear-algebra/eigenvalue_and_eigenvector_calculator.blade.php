<x-calc.page
    title="Eigenvalue and Eigenvector Calculator - SolveKit"
    description="Free eigenvalue and eigenvector calculator: all eigenvalues (real and complex) and eigenvectors, exact when the eigenvalues are rational."
    lede="Find eigenvalues and eigenvectors."
    about="An eigenvector keeps its direction under A: Av = λv. The eigenvalues are the roots of det(λI − A); each eigenvector spans the null space of A − λI. Rational eigenvalues give exact eigenvectors with their algebraic and geometric multiplicities. Also known as eigenvalue calculator and eigenvector calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'eigen']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What are the eigenvalues of [[4, 1], [2, 3]]?', 'answer' => '5, 2.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="4 1
2 3" rows="4" />

    <x-calc.result label="Eigenvalues" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '4 1
2 3'],
        'Repeated' => ['a' => '2 0 0
1 3 0
0 0 3'],
        'Rotation' => ['a' => '0 -1
1 0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'eigenvalues' => ['label' => 'Eigenvalues'],
            'vectors' => ['label' => 'Eigenvectors'],
            'charpoly' => ['label' => 'Characteristic polynomial'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Av = λv</li>
            <li>det(λI − A) = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
