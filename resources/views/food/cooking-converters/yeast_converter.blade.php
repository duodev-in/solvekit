<x-calc.page
    title="Yeast Converter - SolveKit"
    description="Free yeast converter: swap fresh (cake), active dry and instant yeast in grams, teaspoons, packets and cakes."
    lede="Convert between fresh, active dry and instant yeast."
    about="Bakers convert by weight: fresh yeast : active dry : instant ≈ 1 : 0.4 : 0.33. One ¼ oz (7 g) packet of dry yeast holds 2¼ teaspoons and replaces one 0.6 oz (17 g) cake of fresh yeast. Instant yeast can be mixed straight into the flour; active dry is traditionally proofed in warm water first. These ratios are baking conventions, so watch the dough rather than the clock."
    :calc="['engine' => 'fd-convert', 'tool' => 'yeast', 'fields' => ['amount', 'unit', 'from', 'to']]"
    :how-to="[
        ['name' => 'Enter the amount and unit from the recipe', 'text' => ''],
        ['name' => 'Choose the yeast you will use', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much instant yeast replaces 1 packet of active dry?', 'answer' => '5.78 g = 1⅞ tsp (1.86) = 0.83 packets.'],
        ['question' => 'How much fresh yeast replaces 7 g of instant?', 'answer' => '21.2 g (1.25 cakes of 0.6 oz).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['packet' => 'Packets (¼ oz, 7 g)', 'tsp' => 'Teaspoons', 'tbsp' => 'Tablespoons', 'g' => 'Grams', 'oz' => 'Ounces', 'cake' => 'Cakes (0.6 oz fresh)']" selected="packet" />
        <x-calc.select name="from" label="Yeast in the recipe" :options="['active' => 'Active dry', 'instant' => 'Instant', 'fresh' => 'Fresh (compressed)']" selected="active" />
    </div>

    <x-calc.select name="to" label="Convert to" :options="['instant' => 'Instant', 'active' => 'Active dry', 'fresh' => 'Fresh (compressed)']" selected="instant" />

    <x-calc.result label="Yeast to use" />

    <x-calc.options :decimals="false" :examples="[
        '1 packet active' => ['amount' => 1, 'unit' => 'packet', 'from' => 'active', 'to' => 'instant'],
        '7 g instant to fresh' => ['amount' => 7, 'unit' => 'g', 'from' => 'instant', 'to' => 'fresh'],
        '1 cake fresh' => ['amount' => 1, 'unit' => 'cake', 'from' => 'fresh', 'to' => 'active'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fresh' => ['label' => 'Fresh yeast'],
            'active' => ['label' => 'Active dry yeast'],
            'instant' => ['label' => 'Instant yeast'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fresh : active dry : instant = 1 : 0.4 : 0.33</li>
            <li>1 packet = 7 g = 2¼ tsp</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
