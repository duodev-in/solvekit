<x-calc.page
    title="QR Decomposition Calculator - SolveKit"
    description="Free QR decomposition calculator: A = QR with orthonormal Q and upper triangular R (Householder)."
    lede="Factor A = QR."
    about="QR writes A as an orthogonal Q times an upper triangular R; Gram–Schmidt on the columns gives the same idea. It is the stable way to solve least squares problems and the heart of the QR eigenvalue algorithm."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'qr']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Factor [[1, 1], [1, −1], [1, 0]].', 'answer' => 'See R in the grid and Q in the details.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 1
1 -1
1 0" rows="4" />

    <x-calc.result label="QR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 1
1 -1
1 0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'Q' => ['label' => 'Q'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = QR</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
