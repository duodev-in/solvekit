<x-calc.page
    title="Decimal to Percent Converter - SolveKit"
    description="Free decimal to percent converter: move the decimal point two places, with the fraction equivalent."
    lede="Convert a decimal to a percent."
    about="A decimal becomes a percentage when multiplied by 100: 0.375 = 37.5%, 1.2 = 120% and 0.005 = 0.5%. The fraction is shown in lowest terms."
    :calc="['engine' => 'mt-percent', 'tool' => 'to_percent', 'fields' => ['value'], 'from' => 'decimal']"
    :how-to="[
        ['name' => 'Type the decimal', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 0.375 as a percent?', 'answer' => '37.5%.'],
    ]"
>
    <x-calc.field name="value" label="Decimal" value="0.375" type="text" inputmode="decimal" />

    <x-calc.result label="As a percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '0.375'],
        'Over one' => ['value' => '1.2'],
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
            <li>p = d × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
