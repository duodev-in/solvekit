<x-calc.page
    title="Cramer's Rule Calculator - SolveKit"
    description="Free Cramer's rule calculator: solve Ax = b with determinants, xᵢ = det Aᵢ ÷ det A, exactly."
    lede="Solve a system with Cramer's rule."
    about="For a square system with det A ≠ 0, each unknown is a ratio of determinants: xᵢ = det(Aᵢ)/det(A), where Aᵢ has column i replaced by b. Elegant for 2 × 2 and 3 × 3; elimination is faster for large systems."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a', 'b'], 'op' => 'cramer']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'Solve 2x + y − z = 8, −3x − y + 2z = −11, −2x + y + 2z = −3.', 'answer' => 'x1 = 2, x2 = 3, x3 = −1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Matrix A" value="2 1 -1
-3 -1 2
-2 1 2" rows="4" />
        <x-calc.textarea name="b" label="Right-hand side b (one number per row)" value="8
-11
-3" rows="4" />
    </div>

    <x-calc.result label="Solution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2 1 -1
-3 -1 2
-2 1 2', 'b' => '8
-11
-3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'det' => ['label' => 'det A'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>xᵢ = det Aᵢ ÷ det A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
