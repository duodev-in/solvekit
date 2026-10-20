<x-calc.page
    title="Fraction To Decimal Converter - SolveKit"
    description="Free fraction to decimal converter: the exact decimal of a fraction, with the repeating block marked and whether it terminates."
    lede="Convert a fraction to a decimal."
    about="Divide the numerator by the denominator. The decimal terminates when the denominator (in lowest terms) has no prime factors other than 2 and 5 (3/8 = 0.375); otherwise it repeats forever, shown with the repeating block in brackets (5/12 = 0.41(6))."
    :calc="['engine' => 'mt-frac', 'tool' => 'to_decimal', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 5/12 as a decimal?', 'answer' => '0.41(6).'],
        ['question' => 'And 1/7?', 'answer' => '0.(142857).'],
    ]"
>
    <x-calc.field name="value" label="Fraction" value="5/12" type="text" inputmode="text" />

    <x-calc.result label="As a decimal" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '5/12'],
        'Seven' => ['value' => '1/7'],
        'Terminating' => ['value' => '3/8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kind' => ['label' => 'Type'],
            'rounded' => ['label' => 'Rounded to 10 places'],
            'percent' => ['label' => 'Percent'],
            'why' => ['label' => 'Why'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a ÷ b by long division</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
