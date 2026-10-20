<x-calc.page
    title="Repeating Decimal to Fraction Calculator - SolveKit"
    description="Free repeating decimal to fraction calculator: turn a recurring decimal such as 0.(3) or 1.2(45) into an exact fraction with the algebra shown."
    lede="Convert a repeating decimal to a fraction."
    about="Write the repeating digits in brackets. For x = 0.2(45): 1000x = 245.(45) and 10x = 2.(45); subtracting gives 990x = 243, so x = 243/990 = 27/110. Every repeating decimal is a rational number."
    :calc="['engine' => 'mt-frac', 'tool' => 'from_decimal', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What fraction is 0.2(45)?', 'answer' => '27/110.'],
        ['question' => 'And 0.(9)?', 'answer' => '1 (0.999… equals 1).'],
    ]"
>
    <x-calc.field name="value" label="Repeating decimal" value="0.2(45)" type="text" help="Put the repeating block in brackets" inputmode="text" />

    <x-calc.result label="As a fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '0.2(45)'],
        'Nines' => ['value' => '0.(9)'],
        'Third' => ['value' => '0.(3)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mixed' => ['label' => 'Mixed number'],
            'percent' => ['label' => 'Percent'],
            'check' => ['label' => 'Back to a decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>10ⁿ⁺ᵏx − 10ⁿx</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
