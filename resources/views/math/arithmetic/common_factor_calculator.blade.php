<x-calc.page
    title="Common Factor Calculator - SolveKit"
    description="Free common factor calculator: every factor that two or more numbers share, and the greatest one."
    lede="List the common factors."
    about="Common factors divide each of the numbers. They are exactly the factors of the greatest common factor: the common factors of 24 and 36 are the factors of 12, namely 1, 2, 3, 4, 6 and 12."
    :calc="['engine' => 'mt-number', 'tool' => 'gcf', 'fields' => ['numbers'], 'want' => 'gcf']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What are the common factors of 24 and 36?', 'answer' => '1, 2, 3, 4, 6, 12.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="24, 36" type="text" help="Two or more whole numbers separated by commas" inputmode="text" />

    <x-calc.result label="Greatest common factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '24, 36'],
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
            <li>gcd(a, b) = gcd(b, a mod b)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
