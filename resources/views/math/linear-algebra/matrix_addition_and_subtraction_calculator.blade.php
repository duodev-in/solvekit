<x-calc.page
    title="Matrix Addition and Subtraction Calculator - SolveKit"
    description="Free matrix addition and subtraction calculator: A + B and A − B entry by entry."
    lede="Add or subtract matrices."
    about="Matrices of the same size add entry by entry: (A + B)ᵢⱼ = aᵢⱼ + bᵢⱼ. Subtraction works the same way. Addition is commutative; multiplication is not."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['op', 'a', 'b']]"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Add the two 3 × 3 example matrices.', 'answer' => 'See the grid; the top-left entry is 2 + 1 = 3.'],
    ]"
>
    <x-calc.select name="op" label="Operation" :options="['add' => 'A + B', 'sub' => 'A − B']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Matrix A" value="2 1 1
1 3 2
1 0 0" rows="4" />
        <div data-show-when="op:add,sub,mul,hadamard,kron" hidden>
            <x-calc.textarea name="b" label="Matrix B" value="1 0 2
0 1 0
1 1 1" rows="4" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 1
1 3 2
1 0 0', 'b' => '1 0 2
0 1 0
1 1 1', 'op' => 'add'],
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
            <li>(A ± B)ᵢⱼ = aᵢⱼ ± bᵢⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
