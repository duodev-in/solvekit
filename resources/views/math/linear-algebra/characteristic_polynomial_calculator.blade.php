<x-calc.page
    title="Characteristic Polynomial Calculator - SolveKit"
    description="Free characteristic polynomial calculator: det(λI − A) exactly, with the eigenvalues."
    lede="Find the characteristic polynomial."
    about="The characteristic polynomial p(λ) = det(λI − A) has the eigenvalues as roots. Its constant term is (−1)ⁿ det A and the λⁿ⁻¹ coefficient is −trace A. It is computed exactly by the Faddeev–LeVerrier method."
    :calc="['engine' => 'mt-matrix', 'tool' => 'matrix', 'fields' => ['a'], 'op' => 'charpoly']"
    :how-to="[
        ['name' => 'Type the matrix', 'text' => 'One row per line, entries separated by spaces or commas; fractions such as 1/2 are fine (up to 8 × 8).'],
        ['name' => 'Read the result', 'text' => 'The result matrix is in the grid and every step is in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the characteristic polynomial of [[1, 2], [3, 4]]?', 'answer' => 'p(λ) = λ² − 5λ − 2.'],
    ]"
>
    <x-calc.textarea name="a" label="Matrix A" value="1 2
3 4" rows="4" />

    <x-calc.result label="Characteristic polynomial" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1 2
3 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'size' => ['label' => 'Size of A'],
            'det' => ['label' => 'Determinant'],
            'trace' => ['label' => 'Trace'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Result matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p(λ) = det(λI − A)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
