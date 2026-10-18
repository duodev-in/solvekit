<x-calc.page
    title="Tap Water Calculator - SolveKit"
    description="Free tap water calculator: money and plastic bottles saved by drinking tap water instead of bottled water, and the CO₂ of both."
    lede="Work out what drinking tap water instead of bottled water saves."
    about="Bottled water costs = liters drunk ÷ bottle size × bottle price; tap water costs a tiny fraction. Each bottle's plastic (PET) emits about 3.9 kg CO₂e per kg to make (DESNZ 2025); supplying tap water emits about 0.19 kg CO₂e per m³. A 500 mL PET bottle typically weighs 10–15 g; weigh yours for an exact figure."
    :calc="['engine' => 'eco-living', 'tool' => 'tap_water', 'fields' => ['liters', 'people', 'bottle_l', 'bottle_price', 'bottle_g', 'tap_price'], 'data' => ['materials' => config('ecology_data.materials')]]"
    :how-to="[
        ['name' => 'Enter how much you drink', 'text' => 'And the bottle you would buy.'],
        ['name' => 'Enter your tap water price', 'text' => 'Per m³ (1,000 liters).'],
    ]"
    :faqs="[
        ['question' => 'How much does bottled water cost a year?', 'answer' => '1.5 L a day in 500 mL bottles at $1 is about $1,100 a year.'],
        ['question' => 'How many bottles is that?', 'answer' => 'About 1,100 a year.'],
        ['question' => 'Is tap water safe?', 'answer' => 'In most places with public supply, yes; check your local water report.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="liters" label="Water drunk per day" value="1.5" min="0" step="0.1" suffix="L" />
        <x-calc.field name="people" label="People" value="1" min="1" step="1" />
        <x-calc.field name="bottle_l" label="Bottle size" value="0.5" min="0.05" step="0.05" suffix="L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bottle_price" label="Price per bottle" value="1" min="0" step="0.01" suffix="$" />
        <x-calc.field name="bottle_g" label="Bottle weight" value="12" min="0" step="0.1" suffix="g" />
        <x-calc.field name="tap_price" label="Tap water price" value="4" min="0" step="0.01" suffix="$/m³" />
    </div>

    <x-calc.result label="Saved a year by drinking tap water" />

    <x-calc.options :examples="[
        '1.5 L a day, $1 bottles' => ['liters' => 1.5, 'people' => 1, 'bottle_l' => 0.5, 'bottle_price' => 1, 'bottle_g' => 12, 'tap_price' => 4],
        'Family of 4' => ['liters' => 1.5, 'people' => 4, 'bottle_l' => 1.5, 'bottle_price' => 0.8, 'bottle_g' => 30, 'tap_price' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bottles' => ['label' => 'Bottles'],
            'plastic' => ['label' => 'Plastic'],
            'tap_co2' => ['label' => 'Tap water CO₂'],
            'volume' => ['label' => 'Water'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bottles = liters a year ÷ bottle size</li>
            <li>plastic CO₂ = kg PET × 3.864 kg CO₂e/kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
