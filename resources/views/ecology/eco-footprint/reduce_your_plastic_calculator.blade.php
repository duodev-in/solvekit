<x-calc.page
    title="Reduce Your Plastic Calculator - SolveKit"
    description="Free reduce your plastic calculator: plastic and money saved each year by switching to a refillable bottle, reusable bags, your own cup and refills."
    lede="Work out how much plastic and money simple swaps save."
    about="Each swap avoids a number of single-use items a week; plastic saved = items × weight, and money saved = items × their price. Weights are typical values to edit; weigh your own items for an exact figure. Making plastic emits about 3.2 kg CO₂e per kg (DESNZ average plastics)."
    :calc="['engine' => 'eco-footprint', 'tool' => 'reduce_plastic', 'fields' => ['bottles', 'bottle_g', 'bottle_price', 'bags', 'bag_g', 'bag_price', 'cups', 'cup_g', 'cup_price', 'soap', 'soap_g', 'soap_price'], 'data' => ['materials' => config('ecology_data.materials')]]"
    :how-to="[
        ['name' => 'Enter each swap', 'text' => 'Items replaced a week, their weight and price.'],
    ]"
    :faqs="[
        ['question' => 'How much plastic does a refillable bottle save?', 'answer' => 'About 4–5 kg a year for one bottled drink a day.'],
        ['question' => 'Are reusable bags worth it?', 'answer' => 'Yes, if they are used many times; see the Bag Footprint Calculator.'],
        ['question' => 'What else can I swap?', 'answer' => 'Bar soap, refill stations and buying loose produce.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bottles" label="Bottled drinks replaced per week" value="7" min="0" step="1" />
        <x-calc.field name="bottle_g" label="Bottle weight" value="12" min="0" suffix="g" />
        <x-calc.field name="bottle_price" label="Price each" value="1" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bags" label="Carrier bags replaced per week" value="5" min="0" step="1" />
        <x-calc.field name="bag_g" label="Bag weight" value="8.12" min="0" suffix="g" />
        <x-calc.field name="bag_price" label="Price each" value="0.1" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cups" label="Takeaway cups replaced per week" value="3" min="0" step="1" />
        <x-calc.field name="cup_g" label="Cup and lid weight" value="12" min="0" suffix="g" />
        <x-calc.field name="cup_price" label="Discount per cup" value="0.25" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="soap" label="Soap or shampoo bottles replaced per week" value="0.25" min="0" step="0.05" />
        <x-calc.field name="soap_g" label="Bottle weight" value="30" min="0" suffix="g" />
        <x-calc.field name="soap_price" label="Saving each" value="1" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Plastic you would avoid" />

    <x-calc.options :examples="[
        'Simple swaps' => ['bottles' => 7, 'bottle_g' => 12, 'bottle_price' => 1, 'bags' => 5, 'bag_g' => 8.12, 'bag_price' => 0.1, 'cups' => 3, 'cup_g' => 12, 'cup_price' => 0.25, 'soap' => 0.25, 'soap_g' => 30, 'soap_price' => 1],
        'Office of 20 refilling bottles' => ['bottles' => 140, 'bottle_g' => 12, 'bottle_price' => 1, 'bags' => 0, 'bag_g' => 8.12, 'bag_price' => 0.1, 'cups' => 60, 'cup_g' => 12, 'cup_price' => 0.25, 'soap' => 0, 'soap_g' => 30, 'soap_price' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'money' => ['label' => 'Money'],
            'items' => ['label' => 'Items'],
            'decade' => ['label' => 'Over 10 years'],
        ]" />
        <x-calc.quick-ref heading="By swap" name="swaps" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>plastic saved = Σ items a week × 52.18 × weight</li>
            <li>money saved = Σ items × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
