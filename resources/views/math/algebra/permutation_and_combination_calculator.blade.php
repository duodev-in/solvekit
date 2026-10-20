<x-calc.page
    title="Permutation and Combination Calculator - SolveKit"
    description="Free permutation and combination calculator: nPr, nCr and both with repetition, exactly."
    lede="Count permutations and combinations."
    about="Permutations count ordered arrangements, P(n, r) = n!/(n − r)!; combinations count unordered selections, C(n, r) = n!/(r!(n − r)!). With repetition allowed there are nʳ ordered and C(n + r − 1, r) unordered choices."
    :calc="['engine' => 'mt-alg2', 'tool' => 'binomial', 'fields' => ['n', 'k'], 'mode' => 'perm']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many ways can 3 of 10 people finish first, second and third?', 'answer' => '720.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="n" value="10" type="text" inputmode="decimal" />
        <x-calc.field name="k" label="k" value="3" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="C(n, k)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '10', 'k' => '3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'comb' => ['label' => 'Combinations C(n, k)'],
            'perm' => ['label' => 'Permutations P(n, k)'],
            'combrep' => ['label' => 'Combinations with repetition'],
            'permrep' => ['label' => 'Permutations with repetition'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C(n, k) = n! ÷ (k!(n − k)!)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
