<x-calc.page
    title="Cigarette Calculator - SolveKit"
    description="Free cigarette calculator: cigarettes smoked, packs, money spent (in your currency), pack-years and the estimated time lost."
    lede="See what smoking adds up to."
    about="Cigarettes = per day × 365.25 × years; pack-years = packs a day × years. The time estimate uses about 11 minutes of life expectancy lost per cigarette (Shaw et al., BMJ 2000), an average, not a personal prediction. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'cigarettes', 'fields' => ['per_day', 'years', 'pack_size', 'price']]"
    :how-to="[
        ['name' => 'Enter how much and how long', 'text' => ''],
        ['name' => 'Enter the pack price', 'text' => 'In your currency.'],
    ]"
    :faqs="[
        ['question' => 'What do 15 a day for 12 years at 10 a pack add up to?', 'answer' => '9.0 pack-years; $32,872.50 spent.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="per_day" label="Cigarettes a day" value="15" min="0" step="1" />
        <x-calc.field name="years" label="Years smoking" value="12" min="0" step="any" />
        <x-calc.field name="pack_size" label="Cigarettes a pack" value="20" min="0" step="1" />
    </div>

    <x-calc.field name="price" label="Price per pack" value="10" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Cigarettes smoked" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['per_day' => 15, 'years' => 12, 'pack_size' => 20, 'price' => 10],
        'India' => ['per_day' => 10, 'years' => 8, 'pack_size' => 10, 'price' => 170],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'packs' => ['label' => 'Packs'],
            'cost' => ['label' => 'Money spent'],
            'packYears' => ['label' => 'Pack-years'],
            'time' => ['label' => 'Time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cigarettes = per day × 365.25 × years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
