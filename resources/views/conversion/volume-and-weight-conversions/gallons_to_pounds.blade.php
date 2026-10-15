@php
    $groups = collect(config('substances'))->only(['liquids']);
    $substances = $groups->flatMap(fn ($group) => $group['items'])->all();
@endphp

<x-calc.page
    title="Gallons to Pounds Converter - SolveKit"
    description="Professional gallons to pounds converter for liquids. Convert gallon volume to weight in pounds based on substance density. Perfect for cooking and industry."
    lede="Find how much a number of US gallons of a liquid weighs."
    about="Weight is volume times density. A US gallon is 3.785 L, so a liquid weighs 8.345 lb per gallon for every 1 g/mL of density. Densities here are typical values at about 20 °C."
    :calc="['engine' => 'substance', 'volumeUnits' => config('units.volume'), 'massUnits' => config('units.mass'), 'volume' => 'gal_us', 'mass' => 'lb', 'substances' => $substances, 'rows' => ['mass' => ['kg', 'oz', 'g']], 'compare' => ['water', 'milk', 'vegetable_oil', 'honey', 'gasoline', 'diesel', 'ethanol', 'mercury']]"
    :how-to="[
        ['name' => 'Pick the liquid', 'text' => 'Its density fills in, or type your own.'],
        ['name' => 'Enter the gallons', 'text' => 'The weight updates as you type.'],
    ]"
    :faqs="[
        ['question' => 'How much does a gallon of water weigh?', 'answer' => 'About 8.33 lb at room temperature (8.345 lb at 4 °C, where water is densest).'],
        ['question' => 'How much does a gallon of gasoline weigh?', 'answer' => 'About 6.1 to 6.3 lb, depending on the blend and temperature.'],
        ['question' => 'Why do different liquids weigh different amounts?', 'answer' => 'A gallon is a fixed volume. Heavier (denser) liquids pack more mass into that volume.'],
    ]"
>
    <x-calc.substance :groups="$groups" selected="water" label="Liquid" />

    <x-calc.field name="value" label="Volume" value="5" min="0" suffix="gal" suffix-ref="value-suffix" placeholder="US gallons" />

    <x-calc.result label="Pounds" />

    <x-calc.options :examples="[
        'Water jug 5 gal' => ['value' => 5, 'substance' => 'water'],
        'Fuel tank 15 gal' => ['value' => 15, 'substance' => 'gasoline'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Also weighs" name="also" :generated="true" />
        <x-calc.quick-ref heading="Same volume of other liquids" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mL = gallons × 3,785.411784</li>
            <li>grams = mL × density (g/mL)</li>
            <li>pounds = grams ÷ 453.59237</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
