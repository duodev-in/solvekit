<x-calc.page
    title="Matrix Power Calculator - SolveKit"
    description="Free matrix power calculator: Aⁿ for whole n (negative via the inverse), exactly."
    lede="Raise a matrix to a power."
    about="Aⁿ multiplies A by itself n times; repeated squaring keeps it fast. A⁻ⁿ = (A⁻¹)ⁿ, and A⁰ = I. Powers of [[1, 1], [1, 0]] give Fibonacci numbers."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a', 'n'], 'op' => 'power']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is [[1, 1], [1, 0]]¹⁰?', 'answer' => 'The grid shows [[89, 55], [55, 34]].'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 1
1 0" rows="4" />

    <x-calc.field name="n" label="Power n" value="10" min="-20" max="200" step="1" />

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 1
1 0', 'n' => 10],
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
            <li>Aⁿ = A·A·…·A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
