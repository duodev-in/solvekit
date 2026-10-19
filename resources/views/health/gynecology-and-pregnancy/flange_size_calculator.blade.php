<x-calc.page
    title="Flange Size Calculator - SolveKit"
    description="Free breast pump flange size calculator: the flange (breast shield) size from your nipple diameter."
    lede="Find your breast pump flange size."
    about="Measure the nipple diameter at its base (not the areola), in millimetres, ideally after pumping. A common guide is to add 2–4 mm to choose the flange tunnel size. A good fit lets the nipple move freely without much areola being pulled in, and pumping should not hurt. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'flange', 'fields' => ['nipple']]"
    :how-to="[
        ['name' => 'Measure the nipple diameter', 'text' => 'With a ruler or a sizing card.'],
    ]"
    :faqs="[
        ['question' => 'What flange suits an 18 mm nipple?', 'answer' => '21 mm (Nipple 18 mm + about 2–4 mm: try 20–22 mm).'],
    ]"
>
    <x-calc.field name="nipple" label="Nipple diameter at the base" value="18" min="0" max="40" step="any" suffix="mm" />

    <x-calc.result label="Suggested flange size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['nipple' => 18],
        'Small' => ['nipple' => 13],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Range to try'],
            'fit' => ['label' => 'Good fit'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>flange ≈ nipple + 2–4 mm</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
