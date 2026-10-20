<x-calc.page
    title="Fraction to Percent Calculator - SolveKit"
    description="Free fraction to percent calculator: convert a fraction or mixed number to a percentage, exactly, with repeating decimals shown."
    lede="Convert a fraction to a percent."
    about="To convert a fraction to a percentage, divide the top by the bottom and multiply by 100: 3/8 = 0.375 = 37.5%. Fractions whose denominators have prime factors other than 2 and 5 give repeating decimals, such as 1/3 = 33.(3)%."
    :calc="['engine' => 'mt-percent', 'tool' => 'to_percent', 'fields' => ['value'], 'from' => 'fraction']"
    :how-to="[
        ['name' => 'Type the fraction', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 3/8 as a percent?', 'answer' => '37.5%.'],
        ['question' => 'And 2/3?', 'answer' => '66.(6)%.'],
    ]"
>
    <x-calc.field name="value" label="Fraction" value="3/8" type="text" help="Fractions, mixed numbers (1 1/4) or decimals" inputmode="text" />

    <x-calc.result label="As a percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '3/8'],
        'Repeating' => ['value' => '2/3'],
        'Mixed' => ['value' => '1 1/4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'fraction' => ['label' => 'Fraction'],
            'decimal' => ['label' => 'Decimal'],
            'percent' => ['label' => 'Percent'],
            'exact' => ['label' => 'Exactness'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p = a ÷ b × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
