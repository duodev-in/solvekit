<x-calc.page
    title="Dry to Cooked Pasta Converter - SolveKit"
    description="Free dry to cooked pasta converter: cooked weight and cups from dry pasta, servings (2 oz dry each) and how much to cook per person, from USDA data."
    lede="Convert dry pasta to cooked pasta and servings."
    about="Pasta roughly doubles to two-and-a-half times its weight as it absorbs water. The ratio here comes from USDA FoodData Central: dry pasta has 371 kcal per 100 g, cooked 158, so 100 g dry becomes about 235 g cooked. A US serving is 2 oz (56 g) dry, about 1 cup cooked. Cups of dry short pasta differ by shape (penne is lighter per cup than elbows)."
    :calc="['engine' => 'fd-convert', 'tool' => 'pasta', 'fields' => ['mode', 'dry', 'servings', 'shape'], 'unitFields' => ['dry' => collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg'])->all()], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the dry weight or servings', 'text' => ''],
        ['name' => 'Choose the shape', 'text' => 'For cup measures.'],
    ]"
    :faqs="[
        ['question' => 'How much cooked pasta does 8 oz dry make?', 'answer' => '533 g cooked (about 4⅓ cups (4.29)).'],
        ['question' => 'How much dry pasta for 6 people?', 'answer' => '336 g (11.9 oz) dry penne → about 6⅝ cups (6.57) cooked.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Start from" :options="['dry' => 'Dry weight', 'servings' => 'Servings']" selected="dry" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:dry">
            <x-calc.field name="dry" label="Dry pasta" value="8" min="0" placeholder="Dry pasta">
                <label for="calc-dry-unit" class="sr-only">Dry pasta unit</label>
                <select id="calc-dry-unit" name="dry-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'oz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:servings" hidden>
            <x-calc.field name="servings" label="Servings" value="4" min="0" step="1" />
        </div>
    </div>

    <x-calc.select name="shape" label="Shape" :options="['spaghetti' => 'Spaghetti and long pasta', 'elbows' => 'Elbow macaroni', 'penne' => 'Penne', 'rotini' => 'Rotini', 'farfalle' => 'Farfalle (bow ties)']" selected="spaghetti" />

    <x-calc.result label="Cooked pasta" />

    <x-calc.options :decimals="false" :examples="[
        '8 oz spaghetti' => ['mode' => 'dry', 'dry' => 8, 'dry-unit' => 'oz', 'servings' => 4, 'shape' => 'spaghetti'],
        '6 servings' => ['mode' => 'servings', 'dry' => 8, 'dry-unit' => 'oz', 'servings' => 6, 'shape' => 'penne'],
        '500 g penne' => ['mode' => 'dry', 'dry' => 500, 'dry-unit' => 'g', 'servings' => 4, 'shape' => 'penne'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cups' => ['label' => 'Cooked cups'],
            'ounces' => ['label' => 'Cooked ounces'],
            'servings' => ['label' => 'Servings'],
            'dryCups' => ['label' => 'Dry cups'],
            'ratio' => ['label' => 'Yield'],
            'water' => ['label' => 'Cooking water'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cooked = dry × 371 ÷ 158 (USDA energy density)</li>
            <li>serving = 56 g dry</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
