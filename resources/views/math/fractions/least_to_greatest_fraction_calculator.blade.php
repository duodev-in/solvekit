<x-calc.page
    title="Least To Greatest Fraction Calculator - SolveKit"
    description="Free least to greatest calculator: order fractions, decimals, mixed numbers and percentages from smallest to largest."
    lede="Put fractions in order."
    about="Mixed lists are compared exactly: every value is turned into a fraction, rewritten over the least common denominator and ordered by numerator. Percentages are divided by 100 first."
    :calc="['engine' => 'mt-frac', 'tool' => 'compare', 'fields' => ['list']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'How do 3/4, 0.7, 5/8, 72% and 2/3 order?', 'answer' => '5/8 < 2/3 < 0.7 < 72% < 3/4.'],
    ]"
>
    <x-calc.field name="list" label="Numbers" value="3/4, 0.7, 5/8, 72%, 2/3" type="text" help="Fractions, decimals, mixed numbers or percentages, separated by commas" inputmode="text" />

    <x-calc.result label="Least to greatest" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '3/4, 0.7, 5/8, 72%, 2/3'],
        'Negatives' => ['list' => '-1/2, -2/3, 1/4'],
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
            <li>Common denominator, then numerators</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
