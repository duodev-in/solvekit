<x-calc.page
    title="Matrix by Scalar Calculator - SolveKit"
    description="Free scalar multiplication calculator: kA multiplies every entry by k."
    lede="Multiply a matrix by a number."
    about="Multiplying by a scalar scales every entry: 3 × [[1, 2], [3, 4]] = [[3, 6], [9, 12]]. The determinant of kA (n × n) is kⁿ det A."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a', 'k'], 'op' => 'scalar']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is 3 times the matrix [[1, 2], [3, 4]]?', 'answer' => 'The grid shows [[3, 6], [9, 12]].'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
3 4" rows="4" />

    <x-calc.field name="k" label="Scalar k" value="3" type="text" inputmode="decimal" />

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
3 4', 'k' => '3'],
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
            <li>(kA)ᵢⱼ = k aᵢⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
