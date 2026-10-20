<x-calc.page
    title="Subset Calculator - SolveKit"
    description="Free subset calculator: check whether one set is a (proper) subset of another and count subsets of a given size."
    lede="Check subsets."
    about="A ⊆ B when every element of A is in B; A ⊂ B (proper) when also A ≠ B. A set with n elements has 2ⁿ subsets and C(n, k) subsets with exactly k elements."
    :calc="['engine' => 'mt-alg2', 'tool' => 'set_ops', 'fields' => ['a', 'b', 'n'], 'mode' => 'subset']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is {1, 2} a subset of {1, 2, 3, 4}?', 'answer' => 'A ⊂ B (proper subset).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Set A" value="1, 2" type="text" inputmode="text" />
        <x-calc.field name="b" label="Set B" value="1, 2, 3, 4" type="text" inputmode="text" />
    </div>

    <x-calc.field name="n" label="Subsets of B with this many elements" value="2" min="0" step="1" />

    <x-calc.result label="Subset?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1, 2', 'b' => '1, 2, 3, 4', 'n' => 2],
        'No' => ['a' => '1, 5', 'b' => '1, 2, 3, 4', 'n' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Subsets of B'],
            'proper' => ['label' => 'Proper subsets'],
            'size' => ['label' => 'Subsets of size k'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A ⊆ B</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
