<x-calc.page
    title="GCF and LCM Calculator - SolveKit"
    description="Free GCF and LCM calculator: the greatest common factor and least common multiple of two or more numbers together, with prime factors."
    lede="Find the GCF and LCM."
    about="For any two positive whole numbers, GCF × LCM = a × b. Prime factors show both at once: the GCF takes each common prime to its lowest power and the LCM each prime to its highest power."
    :calc="['engine' => 'mt-number', 'tool' => 'gcf', 'fields' => ['numbers'], 'want' => 'both']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What are the GCF and LCM of 60 and 72?', 'answer' => 'GCF 12, LCM 360.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="60, 72" type="text" inputmode="text" />

    <x-calc.result label="GCF and LCM" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '60, 72'],
        'Three' => ['numbers' => '8, 12, 20'],
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
            <li>gcf × lcm = a × b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
