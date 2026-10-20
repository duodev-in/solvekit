<x-calc.page
    title="Common Multiple Calculator - SolveKit"
    description="Free common multiple calculator: the least common multiple of several numbers and the next common multiples."
    lede="Find common multiples."
    about="Every common multiple of a set of numbers is a multiple of their least common multiple. For 6 and 8 the LCM is 24, so the common multiples are 24, 48, 72 and so on."
    :calc="['engine' => 'mt-number', 'tool' => 'gcf', 'fields' => ['numbers'], 'want' => 'lcm']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the first common multiple of 6 and 8?', 'answer' => '24.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="6, 8" type="text" help="Two or more whole numbers separated by commas" inputmode="text" />

    <x-calc.result label="Least common multiple" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '6, 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gcf' => ['label' => 'GCF'],
            'lcm' => ['label' => 'LCM'],
            'common' => ['label' => 'Common factors'],
            'coprime' => ['label' => 'Relatively prime'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lcm(a, b) = ab ÷ gcf(a, b)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
