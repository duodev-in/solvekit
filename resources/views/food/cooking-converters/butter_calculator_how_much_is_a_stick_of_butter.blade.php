<x-calc.page
    title="Butter Calculator - How Much is a Stick of Butter? - SolveKit"
    description="Free butter calculator: convert sticks of butter to cups, tablespoons, grams and ounces, and 250 g blocks to US measures. A US stick is ½ cup, 8 tablespoons, 4 oz or 113 g."
    lede="Convert butter between sticks, cups, spoons and grams."
    about="In the US butter is sold in 1 lb packs of four sticks; each stick is ½ cup, 8 tablespoons or 4 oz (113 g) and is marked with tablespoon lines. In Europe, the UK and Australia butter comes in 250 g blocks, and in India in 100 g and 500 g packs. USDA FoodData Central gives 227 g per cup and 14.2 g per tablespoon."
    :calc="['engine' => 'fd-convert', 'tool' => 'butter', 'fields' => ['amount', 'unit']]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the unit', 'text' => 'Sticks, cups, spoons, weights or blocks.'],
    ]"
    :faqs="[
        ['question' => 'How much is a stick of butter?', 'answer' => '1 stick = ½ cup = 4 oz: 113 g.'],
        ['question' => 'How many cups is 250 g of butter?', 'answer' => '1⅛ cups (1.1).'],
        ['question' => 'How many tablespoons in 100 g of butter?', 'answer' => '7.05 tbsp.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['stick' => 'US sticks', 'cup_us' => 'US cups', 'tbsp_us' => 'Tablespoons', 'tsp_us' => 'Teaspoons', 'g' => 'Grams', 'kg' => 'Kilograms', 'oz' => 'Ounces', 'lb' => 'Pounds', 'block250' => '250 g blocks', 'pack100' => '100 g packs', 'pack500' => '500 g packs']" selected="stick" />
    </div>

    <x-calc.result label="Butter in grams" />

    <x-calc.options :decimals="false" :examples="[
        '1 stick' => ['amount' => 1, 'unit' => 'stick'],
        '250 g block' => ['amount' => 1, 'unit' => 'block250'],
        '100 g' => ['amount' => 100, 'unit' => 'g'],
        '1 cup' => ['amount' => 1, 'unit' => 'cup_us'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sticks' => ['label' => 'US sticks'],
            'cups' => ['label' => 'US cups'],
            'tbsp' => ['label' => 'Tablespoons'],
            'ounces' => ['label' => 'Ounces'],
            'pounds' => ['label' => 'Pounds'],
            'blocks' => ['label' => '250 g blocks'],
        ]" />
        <x-calc.grid heading="Equivalents" name="equivalents" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 stick = ½ cup = 8 tbsp = 4 oz = 113 g</li>
            <li>1 cup = 227 g (USDA)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
