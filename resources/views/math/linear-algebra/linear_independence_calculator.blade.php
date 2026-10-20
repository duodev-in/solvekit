<x-calc.page
    title="Linear Independence Calculator - SolveKit"
    description="Free linear independence calculator: check whether vectors are independent, with the dependency relation if not."
    lede="Check linear independence."
    about="Vectors are independent when no combination except all zeros gives the zero vector. Put them as columns and row-reduce: independent exactly when every column has a pivot. More vectors than dimensions are always dependent."
    :calc="['engine' => 'mt-matrix', 'tool' => 'vectors', 'fields' => ['vecs'], 'mode' => 'indep']"
    :how-to="[
        ['name' => 'Type the vectors', 'text' => 'One vector per line, components separated by spaces or commas.'],
        ['name' => 'Read the result', 'text' => 'Exact fractions where possible.'],
    ]"
    :faqs="[
        ['question' => 'Are (1, 2, 3), (4, 5, 6), (7, 8, 9) independent?', 'answer' => 'Linearly dependent: v1 − 2·v2 + v3 = 0.'],
    ]"
>
    <x-calc.textarea name="vecs" label="Vectors (one per line)" value="1 2 3
4 5 6
7 8 9" rows="4" />

    <x-calc.result label="Independence" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['vecs' => '1 2 3
4 5 6
7 8 9'],
        'Independent' => ['vecs' => '1 0 1
0 1 1
1 1 0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rank' => ['label' => 'Rank'],
            'relation' => ['label' => 'Dependency'],
            'span' => ['label' => 'Span'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>c₁v₁ + … + cₖvₖ = 0 ⇒ all cᵢ = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
