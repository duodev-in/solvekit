<x-calc.page
    title="Percent to Fraction Calculator - SolveKit"
    description="Free percent to fraction calculator: write a percentage as a fraction in lowest terms and as a mixed number."
    lede="Convert a percent to a fraction."
    about="A percentage is a fraction over 100: 37.5% = 37.5/100 = 375/1000 = 3/8 after dividing top and bottom by their greatest common factor. Percentages over 100 give improper fractions (150% = 3/2)."
    :calc="['engine' => 'mt-percent', 'tool' => 'pct_to_fraction', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Type the percentage', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 37.5% as a fraction?', 'answer' => '3/8.'],
    ]"
>
    <x-calc.field name="value" label="Percentage" value="37.5" type="text" suffix="%" inputmode="decimal" />

    <x-calc.result label="As a fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '37.5'],
        'Over 100' => ['value' => '150'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mixed' => ['label' => 'Mixed number'],
            'decimal' => ['label' => 'Decimal'],
            'gcf' => ['label' => 'Simplifying'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p% = p/100 in lowest terms</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
