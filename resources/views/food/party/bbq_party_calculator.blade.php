<x-calc.page
    title="BBQ Party Calculator - SolveKit"
    description="Free BBQ party calculator: how much raw meat to buy (burgers, chicken, pulled pork or brisket), buns and sides for a barbecue, with the cost in your currency."
    lede="Plan meat and sides for a barbecue."
    about="Caterers plan about ½ lb of cooked meat per adult (children half). Raw weight is higher because meat loses weight as it cooks: about 25% for burgers, 35% for bone-in chicken and 50% for pulled pork or brisket. Sides are about 4 oz each per person. These are conventions; adjust for your crowd."
    :calc="['engine' => 'fd-party', 'tool' => 'bbq', 'fields' => ['adults', 'kids', 'meat_per', 'sides', 'burgers', 'chicken', 'pork', 'price_lb']]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Set the meat mix', 'text' => 'Shares of the cooked meat.'],
    ]"
    :faqs="[
        ['question' => 'How much meat for 20 adults and 6 children?', 'answer' => '17.6 lb (7.97 kg) raw (11.5 lb cooked for 23 adult portions (0.5 lb each)).'],
        ['question' => 'How many buns?', 'answer' => '45 buns (10% spare).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="20" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="6" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="meat_per" label="Cooked meat per adult" value="0.5" min="0" step="any" suffix="lb" />
        <x-calc.field name="sides" label="Number of sides" value="3" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="burgers" label="Burgers" value="50" min="0" step="any" suffix="%" />
        <x-calc.field name="chicken" label="Chicken" value="30" min="0" step="any" suffix="%" />
        <x-calc.field name="pork" label="Pulled pork or brisket" value="20" min="0" step="any" suffix="%" />
    </div>

    <x-calc.field name="price_lb" label="Average meat price per lb" value="6" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Raw meat to buy" />

    <x-calc.options :decimals="false" :examples="[
        'Backyard BBQ' => ['adults' => 20, 'kids' => 6, 'meat_per' => 0.5, 'sides' => 3, 'burgers' => 50, 'chicken' => 30, 'pork' => 20, 'price_lb' => 6],
        'Pulled pork party' => ['adults' => 30, 'kids' => 0, 'meat_per' => 0.4, 'sides' => 4, 'burgers' => 0, 'chicken' => 0, 'pork' => 100, 'price_lb' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'burgers' => ['label' => 'Ground beef'],
            'chicken' => ['label' => 'Chicken'],
            'pork' => ['label' => 'Pork or brisket'],
            'buns' => ['label' => 'Buns'],
            'sides' => ['label' => 'Sides'],
            'cost' => ['label' => 'Meat cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cooked = ½ lb × adult portions</li>
            <li>raw = cooked ÷ cooking yield</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
