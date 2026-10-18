<x-calc.page
    title="Plastic Footprint Calculator - SolveKit"
    description="Free plastic footprint calculator: kilograms of plastic you use each year from bottles, bags, cups, containers and straws, against the OECD average per person."
    lede="Work out how much plastic you use in a year."
    about="Count the single-use items you use in a typical week and their weight. A plastic carrier bag weighs about 8 g (Environment Agency); a 500 mL water bottle is typically 10–15 g. Weigh your own items for an exact figure. The OECD reports average plastic waste of 221 kg per person a year in the US, 114 kg in the EU and about 46 kg worldwide."
    :calc="['engine' => 'eco-footprint', 'tool' => 'plastic', 'fields' => ['bottles', 'bottle_g', 'bags', 'bag_g', 'cups', 'cup_g', 'trays', 'tray_g', 'straws', 'straw_g', 'other', 'region'], 'data' => collect(config('ecology_data'))->only(['plastic_per_person', 'materials'])->all()]"
    :how-to="[
        ['name' => 'Count a typical week', 'text' => 'Single-use items and their weight.'],
        ['name' => 'Choose a comparison', 'text' => 'World, US, EU or Japan and Korea.'],
    ]"
    :faqs="[
        ['question' => 'How much plastic does a person use a year?', 'answer' => 'Plastic waste averages about 221 kg per person in the US and 114 kg in the EU (OECD).'],
        ['question' => 'How much does a plastic bag weigh?', 'answer' => 'About 8 g for a thin supermarket bag.'],
        ['question' => 'What can I cut first?', 'answer' => 'Bottled drinks, bags and takeaway cups are easy to replace with reusables.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bottles" label="Drink bottles per week" value="7" min="0" step="1" />
        <x-calc.field name="bottle_g" label="Bottle weight" value="12" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bags" label="Carrier bags per week" value="5" min="0" step="1" />
        <x-calc.field name="bag_g" label="Bag weight" value="8.12" min="0" step="0.01" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cups" label="Takeaway cups per week" value="3" min="0" step="1" />
        <x-calc.field name="cup_g" label="Cup and lid weight" value="12" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="trays" label="Food containers and trays per week" value="6" min="0" step="1" />
        <x-calc.field name="tray_g" label="Container weight" value="20" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="straws" label="Straws and cutlery per week" value="4" min="0" step="1" />
        <x-calc.field name="straw_g" label="Weight each" value="2" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other" label="Other packaging per week" value="100" min="0" suffix="g" />
        <x-calc.select name="region" label="Compare with" :options="collect(config('ecology_data.plastic_per_person'))->map(fn ($r) => $r['name'])->all()" selected="world" />
    </div>

    <x-calc.result label="Your plastic" />

    <x-calc.options :examples="[
        'Typical week' => ['bottles' => 7, 'bottle_g' => 12, 'bags' => 5, 'bag_g' => 8.12, 'cups' => 3, 'cup_g' => 12, 'trays' => 6, 'tray_g' => 20, 'straws' => 4, 'straw_g' => 2, 'other' => 100, 'region' => 'world'],
        'US comparison' => ['bottles' => 10, 'bottle_g' => 12, 'bags' => 8, 'bag_g' => 8.12, 'cups' => 7, 'cup_g' => 12, 'trays' => 10, 'tray_g' => 20, 'straws' => 7, 'straw_g' => 2, 'other' => 300, 'region' => 'us'],
        'Low plastic' => ['bottles' => 0, 'bottle_g' => 12, 'bags' => 0, 'bag_g' => 8.12, 'cups' => 1, 'cup_g' => 12, 'trays' => 2, 'tray_g' => 20, 'straws' => 0, 'straw_g' => 2, 'other' => 50, 'region' => 'eu'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'week' => ['label' => 'Per week'],
            'co2' => ['label' => 'CO₂ to make it'],
            'average' => ['label' => 'Average'],
        ]" />
        <x-calc.quick-ref heading="By item" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>plastic = Σ items a week × 52.18 × weight</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
