<x-calc.page
    title="Matrix Calculator - SolveKit"
    description="Free matrix calculator: add, subtract and multiply matrices, transpose, determinant, inverse, rank, trace, RREF, eigenvalues and more, exactly with fractions."
    lede="Calculate with matrices."
    about="Type each matrix with one row per line. Arithmetic, determinants, inverses and row reduction are exact with fractions; eigenvalues use a numerical method checked against the characteristic polynomial."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['op', 'a', 'b']]"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is A × B for the example matrices?', 'answer' => 'The grid shows the 3 × 2 product; 3 × 2 matrix.'],
    ]"
>
    <x-calc.select name="op" label="Operation" :options="['add' => 'A + B', 'sub' => 'A − B', 'mul' => 'A × B', 'hadamard' => 'A ∘ B (entry-wise)', 'kron' => 'A ⊗ B (Kronecker)', 'transpose' => 'Transpose Aᵀ', 'det' => 'Determinant', 'inverse' => 'Inverse A⁻¹', 'rank' => 'Rank', 'trace' => 'Trace', 'rref' => 'RREF', 'eigen' => 'Eigenvalues', 'charpoly' => 'Characteristic polynomial', 'adjoint' => 'Adjugate']" selected="mul" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Matrix A" value="2 1 1
1 3 2
1 0 0" rows="4" />
        <div data-show-when="op:add,sub,mul,hadamard,kron" hidden>
            <x-calc.textarea name="b" label="Matrix B" value="1 2
3 4
5 6" rows="4" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 1
1 3 2
1 0 0', 'b' => '1 2
3 4
5 6', 'op' => 'mul'],
        'Inverse' => ['a' => '2 1 1
1 3 2
1 0 0', 'b' => '1 2
3 4
5 6', 'op' => 'inverse'],
        'Determinant' => ['a' => '2 1 1
1 3 2
1 0 0', 'b' => '1 2
3 4
5 6', 'op' => 'det'],
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
            <li>(AB)ᵢⱼ = Σ aᵢₖbₖⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
