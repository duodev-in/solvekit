<x-calc.page
    title="Euclidean Algorithm Calculator - SolveKit"
    description="Free Euclidean algorithm calculator: the greatest common divisor by repeated division, with every step."
    lede="Run Euclid's algorithm."
    about="Euclid's algorithm replaces (a, b) with (b, a mod b) until the remainder is 0; the last non-zero remainder is the gcd. It takes very few steps even for huge numbers."
    :calc="['engine' => 'mt-number', 'tool' => 'gcf', 'fields' => ['numbers'], 'want' => 'gcf']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is gcd(1071, 462)?', 'answer' => '21.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="1071, 462" type="text" help="Two or more whole numbers separated by commas" inputmode="text" />

    <x-calc.result label="Greatest common factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '1071, 462'],
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
