<x-calc.page
    title="Cake Pan Converter - SolveKit"
    description="Free cake pan converter: the recipe multiplier to move a cake recipe to a different pan size or shape (round, square, rectangle or Bundt), with the scaled ingredients."
    lede="Scale a cake recipe to a different pan."
    about="A pan holds its area × depth. Divide the new pan's volume by the original's to get the multiplier, then multiply every ingredient by it. Round pan area = π × diameter² ÷ 4; square = side²; rectangle = length × width. Bundt and tube pans are compared by capacity (fill them with water cup by cup to measure). Keep the oven temperature; deeper batter needs longer and sometimes a slightly lower temperature."
    :calc="['engine' => 'fd-convert', 'tool' => 'cake_pan', 'fields' => ['units', 'from_shape', 'from_d', 'from_l', 'from_w', 'from_depth', 'from_cups', 'to_shape', 'to_d', 'to_l', 'to_w', 'to_depth', 'to_cups', 'recipe'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the original pan', 'text' => 'Shape, size and depth.'],
        ['name' => 'Enter the new pan', 'text' => ''],
        ['name' => 'Add the recipe (optional)', 'text' => 'To see every ingredient scaled.'],
    ]"
    :faqs="[
        ['question' => 'How much more batter does a 9 × 13 in pan need than an 8 in round?', 'answer' => '2.33 ×: The new pan holds 2.33 times as much: multiply every ingredient by 2.33.'],
        ['question' => 'Two 9 in rounds into a 9 × 13?', 'answer' => '1.84 × for each round (a 9 × 13 holds about the same as two 9 in rounds).'],
    ]"
>
    <x-calc.segmented name="units" legend="Measured in" :options="['in' => 'Inches', 'cm' => 'Centimetres']" selected="in" />

    <x-calc.select name="from_shape" label="Original pan shape" :options="['round' => 'Round', 'square' => 'Square', 'rectangle' => 'Rectangle', 'bundt' => 'Bundt or tube (by capacity)']" selected="round" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="from_shape:round,square">
            <x-calc.field name="from_d" label="Diameter or side" value="8" min="0" step="any" />
        </div>
        <div data-show-when="from_shape:rectangle" hidden>
            <x-calc.field name="from_l" label="Length" value="9" min="0" step="any" />
        </div>
        <div data-show-when="from_shape:rectangle" hidden>
            <x-calc.field name="from_w" label="Width" value="13" min="0" step="any" />
        </div>
        <div data-show-when="from_shape:round,square,rectangle">
            <x-calc.field name="from_depth" label="Depth" value="2" min="0" step="any" />
        </div>
        <div data-show-when="from_shape:bundt" hidden>
            <x-calc.field name="from_cups" label="Capacity (US cups)" value="10" min="0" step="any" />
        </div>
    </div>

    <x-calc.select name="to_shape" label="New pan shape" :options="['round' => 'Round', 'square' => 'Square', 'rectangle' => 'Rectangle', 'bundt' => 'Bundt or tube (by capacity)']" selected="rectangle" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="to_shape:round,square" hidden>
            <x-calc.field name="to_d" label="Diameter or side" value="9" min="0" step="any" />
        </div>
        <div data-show-when="to_shape:rectangle">
            <x-calc.field name="to_l" label="Length" value="9" min="0" step="any" />
        </div>
        <div data-show-when="to_shape:rectangle">
            <x-calc.field name="to_w" label="Width" value="13" min="0" step="any" />
        </div>
        <div data-show-when="to_shape:round,square,rectangle">
            <x-calc.field name="to_depth" label="Depth" value="2" min="0" step="any" />
        </div>
        <div data-show-when="to_shape:bundt" hidden>
            <x-calc.field name="to_cups" label="Capacity (US cups)" value="12" min="0" step="any" />
        </div>
    </div>

    <x-calc.rows-editor name="recipe" label="Recipe to scale (optional)" :columns="['amount' => 'Amount', 'unit' => 'Unit', 'name' => 'Ingredient']" :rows="[['2', 'cup', 'All-purpose flour'], ['1', 'cup', 'Granulated sugar'], ['1/2', 'cup', 'Butter (salted)'], ['2', 'large', 'Egg (whole, raw)'], ['1', 'tsp', 'Baking powder'], ['3/4', 'cup', 'Whole milk']]" add-label="Add ingredient" help="Amounts like 1 1/2 or ¾; pick or type the ingredient." :text="['amount', 'unit', 'name']" :lists="['unit' => ['cup', 'tbsp', 'tsp', 'g', 'kg', 'oz', 'lb', 'ml', 'l', 'fl oz', 'stick', 'pinch', 'large', 'clove', 'slice'], 'name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <x-calc.result label="Recipe multiplier" />

    <x-calc.options :decimals="false" :examples="[
        '8 in round to 9 × 13' => ['units' => 'in', 'from_shape' => 'round', 'from_d' => 8, 'from_l' => 9, 'from_w' => 13, 'from_depth' => 2, 'from_cups' => 10, 'to_shape' => 'rectangle', 'to_d' => 9, 'to_l' => 9, 'to_w' => 13, 'to_depth' => 2, 'to_cups' => 12, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
        '9 in round to 9 × 13' => ['units' => 'in', 'from_shape' => 'round', 'from_d' => 9, 'from_l' => 9, 'from_w' => 13, 'from_depth' => 2, 'from_cups' => 10, 'to_shape' => 'rectangle', 'to_d' => 9, 'to_l' => 9, 'to_w' => 13, 'to_depth' => 2, 'to_cups' => 12, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
        '9 × 13 to 8 in square' => ['units' => 'in', 'from_shape' => 'rectangle', 'from_d' => 9, 'from_l' => 9, 'from_w' => 13, 'from_depth' => 2, 'from_cups' => 10, 'to_shape' => 'square', 'to_d' => 8, 'to_l' => 9, 'to_w' => 13, 'to_depth' => 2, 'to_cups' => 12, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
        '20 cm to 23 cm round' => ['units' => 'cm', 'from_shape' => 'round', 'from_d' => 20, 'from_l' => 23, 'from_w' => 33, 'from_depth' => 5, 'from_cups' => 10, 'to_shape' => 'round', 'to_d' => 23, 'to_l' => 23, 'to_w' => 33, 'to_depth' => 5, 'to_cups' => 12, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
        'Bundt 10 to 12 cups' => ['units' => 'in', 'from_shape' => 'bundt', 'from_d' => 8, 'from_l' => 9, 'from_w' => 13, 'from_depth' => 2, 'from_cups' => 10, 'to_shape' => 'bundt', 'to_d' => 9, 'to_l' => 9, 'to_w' => 13, 'to_depth' => 2, 'to_cups' => 12, 'recipe' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	tsp	Baking powder
3/4	cup	Whole milk'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'original' => ['label' => 'Original pan'],
            'new' => ['label' => 'New pan'],
            'eggs' => ['label' => 'Eggs'],
            'time' => ['label' => 'Baking'],
        ]" />
        <x-calc.grid heading="Scaled recipe" name="recipe" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>round area = π d² ÷ 4</li>
            <li>multiplier = new area × depth ÷ (old area × depth)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
