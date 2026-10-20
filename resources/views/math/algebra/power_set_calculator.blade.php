<x-calc.page
    title="Power Set Calculator - SolveKit"
    description="Free power set calculator: every subset of a set (up to 12 elements), and how many there are."
    lede="List the power set."
    about="The power set of a set with n elements contains all 2ⁿ subsets, including the empty set ∅ and the set itself. {a, b, c} has 8 subsets."
    :calc="['engine' => 'mt-alg2', 'tool' => 'set_ops', 'fields' => ['a'], 'mode' => 'power']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many subsets does {a, b, c} have?', 'answer' => '8 subsets.'],
    ]"
>
    <x-calc.field name="a" label="Set" value="a, b, c" type="text" inputmode="text" />

    <x-calc.result label="Power set" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 'a, b, c'],
        'Numbers' => ['a' => '1, 2, 3, 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Number of subsets'],
            'proper' => ['label' => 'Proper subsets'],
            'size' => ['label' => 'Elements'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|P(S)| = 2ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
