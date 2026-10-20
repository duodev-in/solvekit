<x-calc.page
    title="Binomial Coefficient Calculator - SolveKit"
    description="Free binomial coefficient calculator: n choose k exactly (BigInt), with permutations and the versions with repetition."
    lede="Calculate n choose k."
    about="The binomial coefficient C(n, k) = n! ÷ (k!(n − k)!) counts the ways to choose k items from n when order does not matter: C(52, 5) = 2,598,960 poker hands. It is also the coefficient of xᵏ in (1 + x)ⁿ and an entry of Pascal's triangle."
    :calc="['engine' => 'mt-alg2', 'tool' => 'binomial', 'fields' => ['n', 'k'], 'mode' => 'comb']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many 5-card hands come from 52 cards?', 'answer' => '2,598,960.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="n" value="52" type="text" inputmode="decimal" />
        <x-calc.field name="k" label="k" value="5" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="C(n, k)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '52', 'k' => '5'],
        'Lottery' => ['n' => '49', 'k' => '6'],
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
