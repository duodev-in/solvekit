<x-calc.page
    title="Tensor Product Calculator - SolveKit"
    description="Free tensor (Kronecker) product calculator: A ⊗ B, each entry of A times the whole of B."
    lede="Find the Kronecker product."
    about="The Kronecker product replaces each entry aᵢⱼ of A with the block aᵢⱼB, so an m × n and a p × q matrix give an mp × nq matrix. It represents the tensor product of linear maps. Also known as Kronecker product calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a', 'b'], 'op' => 'kron']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What size is the Kronecker product of two 2 × 2 matrices?', 'answer' => '4 × 4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Matrix A" value="1 2
3 4" rows="4" />
        <x-calc.textarea name="b" label="Matrix B" value="0 5
6 7" rows="4" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
3 4', 'b' => '0 5
6 7'],
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
            <li>A ⊗ B = [aᵢⱼB]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
