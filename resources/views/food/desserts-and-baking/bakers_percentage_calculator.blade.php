<x-calc.page
    title="Baker's Percentage Calculator - SolveKit"
    description="Free baker's percentage calculator: ingredient weights from flour weight and percentages, or the percentages of an existing recipe, with hydration and total dough."
    lede="Work with baker's percentages."
    about="Bakers write every ingredient as a percentage of the total flour weight, which is always 100%. 65% water on 500 g flour is 325 g. Hydration is the water (and the water in milk and eggs) as a percentage of flour. Enter percentages to get weights for any batch size, or enter a recipe in grams to see its percentages (rows whose name contains flour count as flour)."
    :calc="['engine' => 'fd-bake', 'tool' => 'bakers', 'fields' => ['mode', 'flour', 'pieces', 'recipe']]"
    :how-to="[
        ['name' => 'Choose percentages or a recipe', 'text' => ''],
        ['name' => 'Enter the flour and each ingredient', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do 65% water, 2% salt, 1% yeast and 3% oil mean for 500 g of flour?', 'answer' => '500 g flour, hydration 65%; dough 855 g.'],
        ['question' => 'What are the percentages of my recipe?', 'answer' => 'Switch to recipe mode: 500 g flour, hydration 68%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Start from" :options="['percent' => 'Percentages', 'weights' => 'A recipe in grams']" selected="percent" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:percent">
            <x-calc.field name="flour" label="Total flour" value="500" min="0" step="any" suffix="g" />
        </div>
        <x-calc.field name="pieces" label="Divide into pieces (optional)" value="2" min="0" step="1" />
    </div>

    <x-calc.rows-editor name="recipe" label="Ingredients (name, % or grams)" :columns="['name' => 'Ingredient', 'value' => '% or g']" :rows="[['Water', '65'], ['Table salt', '2'], ['Instant yeast', '1'], ['Olive oil', '3']]" add-label="Add ingredient" help="Percentages of flour in percentage mode; grams in recipe mode." :text="['name', 'value']" />

    <x-calc.result label="Total dough" />

    <x-calc.options :decimals="false" :examples="[
        'Bread' => ['mode' => 'percent', 'flour' => 500, 'pieces' => 2, 'recipe' => 'Water	65
Table salt	2
Instant yeast	1
Olive oil	3'],
        'Recipe' => ['mode' => 'weights', 'flour' => 500, 'pieces' => 2, 'recipe' => 'Bread flour	450
Whole wheat flour	50
Water	340
Table salt	10
Instant yeast	5'],
        'Pizza 1 kg' => ['mode' => 'percent', 'flour' => 1000, 'pieces' => 6, 'recipe' => 'Water	62
Table salt	2.8
Instant yeast	0.2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'flour' => ['label' => 'Flour'],
            'hydration' => ['label' => 'Hydration'],
            'percent' => ['label' => 'Total percentage'],
            'pieces' => ['label' => 'Pieces'],
        ]" />
        <x-calc.grid heading="Formula" name="formula" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ingredient g = flour g × % ÷ 100</li>
            <li>hydration = water ÷ flour</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
