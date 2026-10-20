<x-calc.page
    title="Mixed Number to Improper Fraction Calculator - SolveKit"
    description="Free mixed number to improper fraction calculator: multiply the whole number by the denominator and add the numerator."
    lede="Turn a mixed number into an improper fraction."
    about="Multiply the whole number by the denominator and add the numerator; keep the denominator. 3 2/5 = (3 × 5 + 2)/5 = 17/5. Improper fractions are easier to multiply and divide."
    :calc="['engine' => 'mt-frac', 'tool' => 'mixed_convert', 'fields' => ['value'], 'to' => 'improper']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3 2/5 as an improper fraction?', 'answer' => '17/5.'],
    ]"
>
    <x-calc.field name="value" label="Mixed number" value="3 2/5" type="text" inputmode="text" />

    <x-calc.result label="As an improper fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '3 2/5'],
        'Negative' => ['value' => '-2 3/4'],
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
            <li>q r/b = (qb + r)/b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
