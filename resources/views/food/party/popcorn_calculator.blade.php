<x-calc.page
    title="Popcorn Calculator - SolveKit"
    description="Free popcorn calculator: how many kernels to pop for a crowd, how much popcorn a cup of kernels makes, and the calories, air-popped or oil-popped."
    lede="Work out kernels and popped popcorn."
    about="Popcorn expands about 30 to 35 times by volume: ½ cup of kernels makes about 16 cups popped. A snack serving is about 3–4 cups. Air-popped popcorn has about 31 kcal a cup and oil-popped about 40 (USDA FoodData Central)."
    :calc="['engine' => 'fd-party', 'tool' => 'popcorn', 'fields' => ['mode', 'people', 'per_person', 'kernels', 'style'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter people or kernels', 'text' => ''],
        ['name' => 'Choose air- or oil-popped', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many kernels for 10 people?', 'answer' => '1¼ cups (1¼ cups of kernels → about 40 cups popped (9.46 L)).'],
        ['question' => 'How much does ½ cup of kernels make?', 'answer' => '16 cups.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Start from" :options="['people' => 'People', 'kernels' => 'Kernels']" selected="people" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:people">
            <x-calc.field name="people" label="People" value="10" min="0" step="1" />
        </div>
        <div data-show-when="mode:people">
            <x-calc.field name="per_person" label="Popped cups each" value="4" min="0" step="any" />
        </div>
    </div>

    <div data-show-when="mode:kernels" hidden>
        <x-calc.field name="kernels" label="Kernels" value="0.5" min="0" step="any" suffix="cups" />
    </div>

    <x-calc.select name="style" label="Popped" :options="['air' => 'Air-popped', 'oil' => 'Oil-popped']" selected="air" />

    <x-calc.result label="Kernels to pop" />

    <x-calc.options :decimals="false" :examples="[
        'Movie night' => ['mode' => 'people', 'people' => 10, 'per_person' => 4, 'kernels' => 0.5, 'style' => 'air'],
        '½ cup kernels' => ['mode' => 'kernels', 'people' => 10, 'per_person' => 4, 'kernels' => 0.5, 'style' => 'oil'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tbsp' => ['label' => 'Tablespoons'],
            'kcal' => ['label' => 'Calories'],
            'bowls' => ['label' => 'Bowls'],
            'bags' => ['label' => 'Microwave bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>popped cups = kernel cups × 32</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
