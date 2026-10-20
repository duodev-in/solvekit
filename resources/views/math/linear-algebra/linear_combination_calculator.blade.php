<x-calc.page
    title="Linear Combination Calculator - SolveKit"
    description="Free linear combination calculator: write a target vector as a combination of given vectors, exactly."
    lede="Find a linear combination."
    about="Is the target in the span? Solve c₁v₁ + … + cₖvₖ = target as a linear system. (3, 5) = −2(1, 0) + 5(1, 1). Independent vectors give a unique answer; dependent ones give infinitely many."
    :calc="['engine' => 'mt-matrix', 'tool' => 'vectors', 'fields' => ['vecs', 'target'], 'mode' => 'combo']"
    :how-to="[
        ['name' => 'Type the vectors', 'text' => 'One vector per line, components separated by spaces or commas.'],
        ['name' => 'Read the result', 'text' => 'Exact fractions where possible.'],
    ]"
    :faqs="[
        ['question' => 'Write (3, 5) using (1, 0) and (1, 1).', 'answer' => '−2·v1 + 5·v2.'],
    ]"
>
    <x-calc.textarea name="vecs" label="Vectors (one per line)" value="1 0
1 1" rows="3" />

    <x-calc.field name="target" label="Target vector" value="3 5" type="text" inputmode="text" />

    <x-calc.result label="Linear combination" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['vecs' => '1 0
1 1', 'target' => '3 5'],
        '3D' => ['vecs' => '1 0 1
0 1 1
1 1 0', 'target' => '2 3 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'coefficients' => ['label' => 'Coefficients'],
            'check' => ['label' => 'Check'],
            'span' => ['label' => 'Span'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ cᵢvᵢ = target</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
