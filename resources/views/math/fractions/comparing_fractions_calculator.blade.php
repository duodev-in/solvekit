<x-calc.page
    title="Comparing Fractions Calculator - SolveKit"
    description="Free comparing fractions calculator: which of two fractions is larger, using a common denominator."
    lede="Compare two fractions."
    about="Rewrite both fractions over a common denominator and compare the numerators: 5/8 vs 7/12 → 15/24 vs 14/24, so 5/8 > 7/12. Cross-multiplying (5 × 12 vs 7 × 8) gives the same answer."
    :calc="['engine' => 'mt-frac', 'tool' => 'compare', 'fields' => ['list']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Which is bigger, 5/8 or 7/12?', 'answer' => '5/8 > 7/12.'],
    ]"
>
    <x-calc.field name="list" label="Fractions to compare" value="5/8, 7/12" type="text" help="Separate with commas" inputmode="text" />

    <x-calc.result label="Least to greatest" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '5/8, 7/12'],
        'Equal' => ['list' => '6/9, 2/3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'descending' => ['label' => 'Greatest to least'],
            'lcd' => ['label' => 'Common denominator'],
            'decimals' => ['label' => 'Decimals'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a/b < c/d ⇔ ad < bc (b, d > 0)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
