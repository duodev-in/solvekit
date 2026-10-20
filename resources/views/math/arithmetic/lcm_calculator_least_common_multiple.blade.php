<x-calc.page
    title="LCM Calculator — Least Common Multiple - SolveKit"
    description="Free LCM calculator: the least common multiple of two or more numbers, from prime factors and from the GCF."
    lede="Find the least common multiple."
    about="The least common multiple is the smallest positive number that every number divides. For two numbers lcm(a, b) = a × b ÷ gcf(a, b): lcm(12, 18) = 216 ÷ 6 = 36. With prime factors, take each prime to its highest power. Also known as least common multiple calculator and least common factor calculator."
    :calc="['engine' => 'mt-number', 'tool' => 'gcf', 'fields' => ['numbers'], 'want' => 'lcm']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the LCM of 12 and 18?', 'answer' => '36.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="12, 18" type="text" help="Two or more whole numbers separated by commas" inputmode="text" />

    <x-calc.result label="Least common multiple" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '12, 18'],
        'Three numbers' => ['numbers' => '4, 6, 15'],
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
