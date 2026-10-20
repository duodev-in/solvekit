<x-calc.page
    title="GCF Calculator – Greatest Common Factor - SolveKit"
    description="Free GCF calculator: the greatest common factor of two or more numbers by Euclid's algorithm and by prime factors, with every common factor."
    lede="Find the greatest common factor."
    about="The greatest common factor (GCF, also called the greatest common divisor) is the largest whole number that divides all the numbers. Euclid's algorithm finds it by repeated division: gcd(84, 126) → 126 = 1 × 84 + 42, 84 = 2 × 42 + 0, so the GCF is 42. Also known as GCD calculator, greatest common divisor calculator, greatest common denominator calculator and greatest common factor calculator."
    :calc="['engine' => 'mt-number', 'tool' => 'gcf', 'fields' => ['numbers'], 'want' => 'gcf']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the GCF of 84 and 126?', 'answer' => '42.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="84, 126" type="text" help="Two or more whole numbers separated by commas" inputmode="text" />

    <x-calc.result label="Greatest common factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '84, 126'],
        'Three numbers' => ['numbers' => '48, 180, 600'],
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
