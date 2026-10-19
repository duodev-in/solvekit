<x-calc.page
    title="Fresh to Dry Herb Conversion Calculator - SolveKit"
    description="Free fresh to dried herb converter: swap fresh herbs for dried (3 to 1) or dried for fresh, in teaspoons, tablespoons and cups."
    lede="Swap fresh herbs for dried, or dried for fresh."
    about="Dried herbs are more concentrated, so the kitchen rule is three parts fresh to one part dried: 1 tablespoon of chopped fresh herbs ≈ 1 teaspoon dried. Ground dried herbs are stronger still (use about half as much as crumbled leaves). This is a rule of thumb; taste and adjust, and add dried herbs earlier in cooking and fresh ones near the end."
    :calc="['engine' => 'fd-convert', 'tool' => 'herbs', 'fields' => ['amount', 'unit', 'direction']]"
    :how-to="[
        ['name' => 'Enter the amount the recipe gives', 'text' => ''],
        ['name' => 'Choose the direction', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much dried herb replaces 1 tablespoon fresh?', 'answer' => '1 tsp.'],
        ['question' => 'How much fresh basil for 1 teaspoon dried?', 'answer' => '1 tbsp.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['tsp_us' => 'Teaspoons', 'tbsp_us' => 'Tablespoons', 'cup_us' => 'Cups']" selected="tbsp_us" />
        <x-calc.select name="direction" label="Convert" :options="['to_dried' => 'Fresh to dried', 'to_fresh' => 'Dried to fresh']" selected="to_dried" />
    </div>

    <x-calc.result label="Equivalent amount" />

    <x-calc.options :decimals="false" :examples="[
        '1 tbsp fresh' => ['amount' => 1, 'unit' => 'tbsp_us', 'direction' => 'to_dried'],
        '1 tsp dried' => ['amount' => 1, 'unit' => 'tsp_us', 'direction' => 'to_fresh'],
        '¼ cup fresh' => ['amount' => 0.25, 'unit' => 'cup_us', 'direction' => 'to_dried'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tsp' => ['label' => 'Teaspoons'],
            'tbsp' => ['label' => 'Tablespoons'],
            'ground' => ['label' => 'Ground herbs'],
            'rule' => ['label' => 'Rule'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dried = fresh ÷ 3</li>
            <li>fresh = dried × 3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
