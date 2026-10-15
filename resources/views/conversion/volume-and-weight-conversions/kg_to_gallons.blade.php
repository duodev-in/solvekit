@php
    $groups = collect(config('substances'))->only(['liquids', 'cooking']);
    $substances = $groups->flatMap(fn ($group) => $group['items'])->all();
@endphp

<x-calc.page
    title="Kg to Gallons Converter (Advanced) - SolveKit"
    description="Advanced kg to gallons converter for various substances. Convert weight to volume based on density for liquids, dairy, oils, and cooking ingredients."
    lede="Find how many US gallons a weight in kilograms fills."
    about="Volume is weight divided by density. One kilogram of a substance with a density of 1 g/mL fills 1 liter, which is 0.264 US gallons. Liquid densities are at about 20 °C; dry ingredients are loose bulk densities."
    :calc="['engine' => 'substance', 'volumeUnits' => config('units.volume'), 'massUnits' => config('units.mass'), 'volume' => 'gal_us', 'mass' => 'kg', 'direction' => 'm2v', 'substances' => $substances, 'rows' => ['volume' => ['l', 'qt_us', 'pt_us', 'gal_uk']], 'compare' => ['water', 'milk', 'vegetable_oil', 'honey', 'gasoline', 'diesel', 'flour', 'sugar']]"
    :how-to="[
        ['name' => 'Pick the substance', 'text' => 'Its density fills in, or type your own.'],
        ['name' => 'Enter the weight', 'text' => 'Type the weight in kilograms.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons is 1 kg of water?', 'answer' => 'About 0.265 US gallons, because 1 kg of water is about 1 liter.'],
        ['question' => 'Why does the substance matter?', 'answer' => 'Kilograms measure weight and gallons measure volume. Lighter substances take up more space per kilogram.'],
        ['question' => 'Are these US or imperial gallons?', 'answer' => 'The result is in US gallons; imperial gallons are listed beside it.'],
    ]"
>
    <x-calc.substance :groups="$groups" selected="water" />

    <x-calc.field name="value" label="Weight" value="20" min="0" suffix="kg" suffix-ref="value-suffix" placeholder="Kilograms" />

    <x-calc.result label="US gallons" />

    <x-calc.options :examples="[
        'Cooking oil 18 kg' => ['value' => 18, 'substance' => 'vegetable_oil'],
        'Honey 3 kg' => ['value' => 3, 'substance' => 'honey'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Also fills" name="also" :generated="true" />
        <x-calc.quick-ref heading="Same weight of other substances" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mL = grams ÷ density (g/mL)</li>
            <li>US gallons = mL ÷ 3,785.411784</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
