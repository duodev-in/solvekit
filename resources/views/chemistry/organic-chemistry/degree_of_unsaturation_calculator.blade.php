<x-calc.page
    title="Degree of Unsaturation Calculator - SolveKit"
    description="Free degree of unsaturation calculator (double bond equivalent): rings plus π bonds from a molecular formula."
    lede="Work out the degree of unsaturation (double bond equivalent) of a formula."
    about="The degree of unsaturation, also called the double bond equivalent (DBE) or index of hydrogen deficiency, counts rings plus π bonds: (2C + 2 + N − H − X) ÷ 2. Halogens count like hydrogen; oxygen and sulfur do not change it."
    :calc="['engine' => 'chem-organic', 'tool' => 'unsaturation', 'fields' => ['formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the molecular formula', 'text' => 'With halogens and nitrogen if present.'],
    ]"
    :faqs="[
        ['question' => 'What is the degree of unsaturation of benzene?', 'answer' => '4: one ring and three double bonds.'],
        ['question' => 'Is DBE the same thing?', 'answer' => 'Yes, double bond equivalent and degree of unsaturation are the same number.'],
        ['question' => 'How does oxygen affect it?', 'answer' => 'It does not; oxygen and sulfur are left out.'],
    ]"
>
    <x-calc.field name="formula" label="Molecular formula" value="C6H6" type="text" help="e.g. C6H6, C8H10N4O2, C2H3Cl" />

    <x-calc.result label="Degree of unsaturation" />

    <x-calc.options :decimals="false" :examples="[
        'Benzene' => ['formula' => 'C6H6'],
        'Caffeine' => ['formula' => 'C8H10N4O2'],
        'Vinyl chloride' => ['formula' => 'C2H3Cl'],
        'Cyclohexane' => ['formula' => 'C6H12'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'meaning' => ['label' => 'What it means'],
            'hill' => ['label' => 'Hill formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DoU = (2C + 2 + N − H − X) ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
