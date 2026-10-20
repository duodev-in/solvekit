<x-calc.page
    title="Gram-Schmidt Calculator - SolveKit"
    description="Free Gram-Schmidt calculator: orthogonalise and normalise a set of vectors, exactly before normalising."
    lede="Orthonormalise vectors."
    about="Gram–Schmidt turns independent vectors into an orthonormal set spanning the same space: subtract from each vector its projections on the earlier ones, then divide by the length. Dependent vectors drop out."
    :calc="['engine' => 'mt-matrix', 'tool' => 'vectors', 'fields' => ['vecs'], 'mode' => 'gram']"
    :how-to="[
        ['name' => 'Type the vectors', 'text' => 'One vector per line, components separated by spaces or commas.'],
        ['name' => 'Read the result', 'text' => 'Exact fractions where possible.'],
    ]"
    :faqs="[
        ['question' => 'Orthonormalise (1, 1, 0), (1, 0, 1), (0, 1, 1).', 'answer' => 'The orthogonal set is (1, 1, 0); (1/2, −1/2, 1); (−2/3, 2/3, 2/3).'],
    ]"
>
    <x-calc.textarea name="vecs" label="Vectors (one per line)" value="1 1 0
1 0 1
0 1 1" rows="4" />

    <x-calc.result label="Gram–Schmidt" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['vecs' => '1 1 0
1 0 1
0 1 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'orthogonal' => ['label' => 'Orthogonal set'],
            'orthonormal' => ['label' => 'Orthonormal set'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Orthonormal vectors (rows)" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>uₖ = vₖ − Σ proj_{uⱼ} vₖ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
