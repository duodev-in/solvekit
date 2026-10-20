<x-calc.page
    title="Improper Fraction to Mixed Number Calculator - SolveKit"
    description="Free improper fraction to mixed number calculator: divide to get the whole part and the remainder over the denominator."
    lede="Turn an improper fraction into a mixed number."
    about="Divide the numerator by the denominator: the quotient is the whole number and the remainder goes over the same denominator. 17/5 = 3 remainder 2 = 3 2/5."
    :calc="['engine' => 'mt-frac', 'tool' => 'mixed_convert', 'fields' => ['value'], 'to' => 'mixed']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 17/5 as a mixed number?', 'answer' => '3 2/5.'],
    ]"
>
    <x-calc.field name="value" label="Improper fraction" value="17/5" type="text" inputmode="text" />

    <x-calc.result label="As a mixed number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '17/5'],
        'Large' => ['value' => '125/12'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'improper' => ['label' => 'Improper fraction'],
            'decimal' => ['label' => 'Decimal'],
            'whole' => ['label' => 'Whole part'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a/b = q r/b with a = qb + r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
