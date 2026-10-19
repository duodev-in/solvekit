<x-calc.page
    title="Pancake Recipe Calculator - SolveKit"
    description="Free pancake recipe calculator: a classic American pancake recipe scaled to the number of pancakes or servings, in cups and grams."
    lede="Scale a pancake recipe to your crowd."
    about="The base recipe (1½ cups flour, 3½ tsp baking powder, 1 tbsp sugar, ¼ tsp salt, 1¼ cups milk, 1 egg and 3 tbsp melted butter) makes about eight 4 in pancakes from ¼ cup of batter each. It is scaled to your number and rewritten in handy measures, with weights from USDA densities. A serving is about three pancakes."
    :calc="['engine' => 'fd-bake', 'tool' => 'pancake_recipe', 'fields' => ['mode', 'count', 'servings'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter pancakes or servings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How do I make 16 pancakes?', 'answer' => 'Double the base recipe: 2 × the base recipe (8 four-inch pancakes, ¼ cup batter each).'],
        ['question' => 'How much batter for 6 people?', 'answer' => '4½ cups.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Make" :options="['count' => 'Pancakes', 'servings' => 'Servings']" selected="count" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:count">
            <x-calc.field name="count" label="Pancakes" value="16" min="0" step="1" />
        </div>
        <div data-show-when="mode:servings" hidden>
            <x-calc.field name="servings" label="Servings (3 each)" value="4" min="0" step="1" />
        </div>
    </div>

    <x-calc.result label="Recipe for" />

    <x-calc.options :decimals="false" :examples="[
        '16 pancakes' => ['mode' => 'count', 'count' => 16, 'servings' => 4],
        '6 servings' => ['mode' => 'servings', 'count' => 16, 'servings' => 6],
        '4 pancakes' => ['mode' => 'count', 'count' => 4, 'servings' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'batter' => ['label' => 'Batter'],
            'servings' => ['label' => 'Servings'],
            'griddle' => ['label' => 'Cooking'],
        ]" />
        <x-calc.grid heading="Recipe" name="recipe" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>factor = pancakes ÷ 8</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
