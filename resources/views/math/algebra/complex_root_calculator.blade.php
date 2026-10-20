<x-calc.page
    title="Complex Root Calculator - SolveKit"
    description="Free complex root calculator: all n-th roots of a complex number by De Moivre's theorem, drawn on the Argand diagram."
    lede="Find all n-th roots of a complex number."
    about="Every non-zero complex number has exactly n different n-th roots, equally spaced on a circle of radius r^(1/n): wₖ = r^(1/n) cis((θ + 2πk)/n). The cube roots of −8 are −2 and 1 ± √3 i."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex_roots', 'fields' => ['z1', 'n']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the cube roots of −8?', 'answer' => '1 + 1.7320508i,  −2,  1 − 1.7320508i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="z1" label="Complex number" value="-8" type="text" inputmode="text" />
        <x-calc.field name="n" label="n" value="3" min="2" max="24" step="1" />
    </div>

    <x-calc.result label="Roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '-8', 'n' => 3],
        'Unity' => ['z1' => '1', 'n' => 6],
        'Complex' => ['z1' => '3 + 4i', 'n' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Roots on the Argand diagram" name="argand" />
        <x-calc.rows heading="Details" :rows="[
            'modulus' => ['label' => 'Modulus of each root'],
            'principal' => ['label' => 'Principal root'],
            'spacing' => ['label' => 'Spacing'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>wₖ = r^(1/n) cis((θ + 2πk)/n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
