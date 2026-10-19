<x-calc.page
    title="Pack Year Calculator - SolveKit"
    description="Free pack year calculator: pack-years from cigarettes or packs a day and years smoked, with the USPSTF lung cancer screening threshold."
    lede="Calculate pack-years."
    about="Pack-years = packs smoked a day × years smoked (a pack is 20 cigarettes). The US Preventive Services Task Force (2021) recommends yearly low-dose CT lung screening for adults aged 50–80 with 20 or more pack-years who smoke now or quit within the past 15 years. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'pack_years', 'fields' => ['amount', 'unit', 'years']]"
    :how-to="[
        ['name' => 'Enter how much and for how long', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many pack-years is a pack a day for 25 years?', 'answer' => '25.0.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount a day" value="20" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['cigarettes' => 'Cigarettes', 'packs' => 'Packs']" selected="cigarettes" />
        <x-calc.field name="years" label="Years smoked" value="25" min="0" step="any" />
    </div>

    <x-calc.result label="Pack-years" />

    <x-calc.options :decimals="false" :examples="[
        'Pack a day' => ['amount' => 20, 'unit' => 'cigarettes', 'years' => 25],
        'Half a pack' => ['amount' => 0.5, 'unit' => 'packs', 'years' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'screening' => ['label' => 'Screening'],
            'cigarettes' => ['label' => 'Cigarettes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pack-years = packs a day × years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
