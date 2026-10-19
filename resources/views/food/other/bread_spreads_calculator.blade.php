<x-calc.page
    title="Bread Spreads Calculator - SolveKit"
    description="Free bread spreads calculator: how much butter, peanut butter, jam, cream cheese, mayonnaise or mustard you need for a number of slices or sandwiches, with packages and calories."
    lede="Work out spread for slices or sandwiches."
    about="A regular spread is about 1 tsp of butter, 1 tbsp of peanut butter, jam or cream cheese, ½ tbsp of mayonnaise or 1 tsp of mustard per slice (a convention; thin is half, thick one and a half). Weights and calories come from USDA FoodData Central."
    :calc="['engine' => 'fd-other', 'tool' => 'spreads', 'fields' => ['mode', 'slices', 'sandwiches', 'both', 'spread', 'thickness'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter slices or sandwiches', 'text' => ''],
        ['name' => 'Choose the spread and thickness', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much peanut butter for 12 sandwiches?', 'answer' => '194 g (0.43 × 16 oz jar (454 g)).'],
        ['question' => 'How much butter for 20 slices?', 'answer' => '94.6 g.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Count" :options="['slices' => 'Slices', 'sandwiches' => 'Sandwiches']" selected="sandwiches" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:slices" hidden>
            <x-calc.field name="slices" label="Slices" value="20" min="0" step="1" />
        </div>
        <div data-show-when="mode:sandwiches">
            <x-calc.field name="sandwiches" label="Sandwiches" value="12" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:sandwiches" hidden>
        <x-calc.checkbox name="both" label="Spread both slices" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="spread" label="Spread" :options="['butter' => 'Butter', 'peanut_butter' => 'Peanut butter', 'jam' => 'Jam', 'cream_cheese' => 'Cream cheese', 'mayonnaise' => 'Mayonnaise', 'mustard' => 'Mustard']" selected="peanut_butter" />
        <x-calc.select name="thickness" label="Thickness" :options="['thin' => 'Thin', 'regular' => 'Regular', 'thick' => 'Thick']" selected="regular" />
    </div>

    <x-calc.result label="Spread needed" />

    <x-calc.options :decimals="false" :examples="[
        '12 sandwiches' => ['mode' => 'sandwiches', 'slices' => 20, 'sandwiches' => 12, 'both' => false, 'spread' => 'peanut_butter', 'thickness' => 'regular'],
        'Butter' => ['mode' => 'slices', 'slices' => 20, 'sandwiches' => 12, 'both' => false, 'spread' => 'butter', 'thickness' => 'regular'],
        'Party sandwiches' => ['mode' => 'sandwiches', 'slices' => 20, 'sandwiches' => 40, 'both' => true, 'spread' => 'mayonnaise', 'thickness' => 'thin'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'packages' => ['label' => 'Packages'],
            'cups' => ['label' => 'Cups'],
            'kcal' => ['label' => 'Calories'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>spread = slices × tbsp per slice × thickness</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
