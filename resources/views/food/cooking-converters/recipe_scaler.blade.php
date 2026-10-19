<x-calc.page
    title="Recipe Scaler - SolveKit"
    description="Free recipe scaler: scale a recipe to more or fewer servings or by any factor, with amounts rewritten in handy cups and spoons and weights in grams from USDA data."
    lede="Scale a recipe up or down."
    about="Every ingredient is multiplied by new servings ÷ original servings. Volumes are rewritten in the handiest measure (3 teaspoons become a tablespoon, 4 tablespoons a ¼ cup), eggs are rounded to the nearest half, and weights come from USDA densities when the ingredient is in the table. Cooking time depends on the depth of food, not the amount: a bigger batch in a bigger pan of the same depth bakes in about the same time."
    :calc="['engine' => 'fd-convert', 'tool' => 'scaler', 'fields' => ['mode', 'from_servings', 'to_servings', 'factor', 'recipe'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the recipe', 'text' => 'Amount, unit and ingredient on each row.'],
        ['name' => 'Enter the servings', 'text' => 'Or a multiplier.'],
    ]"
    :faqs="[
        ['question' => 'How do I scale a 4-serving recipe to 10?', 'answer' => 'Multiply everything by 2.5 ×.'],
        ['question' => 'How do I halve a recipe with 3 eggs?', 'answer' => 'Use 1½ eggs: beat 2 eggs and use about three-quarters, or use 2 small eggs.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Scale by" :options="['servings' => 'Servings', 'factor' => 'Multiplier']" selected="servings" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:servings">
            <x-calc.field name="from_servings" label="Original servings" value="4" min="0" step="1" />
        </div>
        <div data-show-when="mode:servings">
            <x-calc.field name="to_servings" label="New servings" value="10" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:factor" hidden>
        <x-calc.field name="factor" label="Multiply by" value="1.5" min="0" step="any" />
    </div>

    <x-calc.rows-editor name="recipe" label="Recipe (amount, unit, ingredient)" :columns="['amount' => 'Amount', 'unit' => 'Unit', 'name' => 'Ingredient']" :rows="[['2', 'cup', 'All-purpose flour'], ['1', 'cup', 'Granulated sugar'], ['1/2', 'cup', 'Butter (salted)'], ['2', 'large', 'Egg (whole, raw)'], ['1', 'tsp', 'Baking powder'], ['3/4', 'cup', 'Whole milk']]" add-label="Add ingredient" help="Amounts like 1 1/2 or ¾; pick or type the ingredient." :text="['amount', 'unit', 'name']" :lists="['unit' => ['cup', 'tbsp', 'tsp', 'g', 'kg', 'oz', 'lb', 'ml', 'l', 'fl oz', 'stick', 'pinch', 'large', 'clove', 'slice'], 'name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <x-calc.result label="Scale factor" />

    <x-calc.options :decimals="false" :examples="[
        '4 to 10' => ['mode' => 'servings', 'from_servings' => 4, 'to_servings' => 10, 'factor' => 1.5, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
        'Halve' => ['mode' => 'factor', 'from_servings' => 4, 'to_servings' => 10, 'factor' => 0.5, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
        'Triple' => ['mode' => 'factor', 'from_servings' => 4, 'to_servings' => 10, 'factor' => 3, 'recipe' => '2	cup	All-purpose flour
1	tsp	Salt
1	packet	Active dry yeast
1 1/2	cup	Water
2	tbsp	Olive oil'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lines' => ['label' => 'Ingredients'],
            'weight' => ['label' => 'Total weight'],
            'unknown' => ['label' => 'Unmatched'],
            'tip' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Scaled recipe" name="recipe" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>factor = new servings ÷ original servings</li>
            <li>new amount = amount × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
