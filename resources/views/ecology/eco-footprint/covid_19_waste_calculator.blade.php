<x-calc.page
    title="COVID-19 Waste Calculator - SolveKit"
    description="Free COVID-19 waste calculator: masks, gloves and wipes a household or group throws away, in items and kilograms."
    lede="Work out how much protective waste masks, gloves and wipes create."
    about="Waste = items per person per day × people × days × the weight of each item. Disposable surgical masks weigh about 3 g, nitrile gloves about 3–4 g each and wet wipes about 3–5 g; these vary by product, so weigh yours for an exact answer. Most are made of polypropylene or other plastics."
    :calc="['engine' => 'eco-footprint', 'tool' => 'covid_waste', 'fields' => ['people', 'days', 'masks', 'mask_g', 'gloves', 'glove_g', 'wipes', 'wipe_g']]"
    :how-to="[
        ['name' => 'Enter the people and days', 'text' => 'For a household or workplace.'],
        ['name' => 'Enter items and weights', 'text' => 'Weigh one of each for an exact figure.'],
    ]"
    :faqs="[
        ['question' => 'How much does a surgical mask weigh?', 'answer' => 'About 3 g.'],
        ['question' => 'What are masks made of?', 'answer' => 'Mostly polypropylene, a plastic.'],
        ['question' => 'Can masks be recycled?', 'answer' => 'Rarely through household recycling; follow local rules.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="people" label="People" value="4" min="1" step="1" />
        <x-calc.field name="days" label="Days" value="30" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="masks" label="Masks per person per day" value="1" min="0" step="0.5" />
        <x-calc.field name="mask_g" label="Mask weight" value="3" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gloves" label="Gloves per person per day" value="0" min="0" step="1" />
        <x-calc.field name="glove_g" label="Glove weight" value="3.5" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wipes" label="Wipes per person per day" value="2" min="0" step="1" />
        <x-calc.field name="wipe_g" label="Wipe weight" value="4" min="0" step="0.1" suffix="g" />
    </div>

    <x-calc.result label="Waste thrown away" />

    <x-calc.options :examples="[
        'Family of 4, a month' => ['people' => 4, 'days' => 30, 'masks' => 1, 'mask_g' => 3, 'gloves' => 0, 'glove_g' => 3.5, 'wipes' => 2, 'wipe_g' => 4],
        'Clinic of 20, a year' => ['people' => 20, 'days' => 365, 'masks' => 3, 'mask_g' => 3, 'gloves' => 10, 'glove_g' => 3.5, 'wipes' => 5, 'wipe_g' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'items' => ['label' => 'Items'],
            'per_person' => ['label' => 'Per person'],
            'per_day' => ['label' => 'Per day'],
        ]" />
        <x-calc.quick-ref heading="By item" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>waste = Σ items/day × people × days × item weight</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
