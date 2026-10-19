<x-calc.page
    title="Taco Bar Calculator - SolveKit"
    description="Free taco bar calculator: meat, tortillas, cheese, toppings, rice and beans for a taco bar from the number of guests, with the meat cost in your currency."
    lede="Plan a taco bar for your guests."
    about="Plan 2–3 tacos per adult with about ¼ lb of cooked meat (children half), 1 oz of cheese, and small amounts of lettuce, salsa, sour cream and guacamole, plus ½ cup each of rice and beans. Cooked meat is about ¾ of its raw weight. These are catering conventions."
    :calc="['engine' => 'fd-party', 'tool' => 'taco', 'fields' => ['adults', 'kids', 'appetite', 'price_lb']]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Choose the appetite', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much taco meat for 20 adults and 5 children?', 'answer' => '5.63 lb (2.55 kg) cooked (7.5 lb (3.4 kg) raw ground meat or chicken).'],
        ['question' => 'How many tortillas?', 'answer' => '62 tortillas or shells (10% spare).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="20" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="5" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="appetite" label="Appetite" :options="['light' => 'Light', 'normal' => 'Average', 'hungry' => 'Hungry']" selected="normal" />
        <x-calc.field name="price_lb" label="Meat price per lb" value="5" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Taco meat (cooked)" />

    <x-calc.options :decimals="false" :examples="[
        'Taco night' => ['adults' => 20, 'kids' => 5, 'appetite' => 'normal', 'price_lb' => 5],
        'Hungry crowd' => ['adults' => 15, 'kids' => 0, 'appetite' => 'hungry', 'price_lb' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'raw' => ['label' => 'Raw meat'],
            'tortillas' => ['label' => 'Tortillas'],
            'cheese' => ['label' => 'Cheese'],
            'toppings' => ['label' => 'Toppings'],
            'sides' => ['label' => 'Sides'],
            'cost' => ['label' => 'Meat cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>meat = ¼ lb × adult portions</li>
            <li>tortillas = 2.5 × portions × 1.1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
