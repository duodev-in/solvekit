<x-calc.page
    title="Food Storage Time Calculator - SolveKit"
    description="Free food storage time calculator: how long 600+ foods keep in the pantry, refrigerator and freezer, unopened or opened, and the date to use them by, from USDA FoodKeeper data."
    lede="Find how long food keeps and when to use it."
    about="Storage times come from the USDA FSIS FoodKeeper data (version 128), which lists pantry, refrigerator and freezer times for over 600 foods, from purchase, after opening or after thawing. Refrigerator times assume 40 °F (4 °C) or below; frozen food at 0 °F (−18 °C) stays safe indefinitely, and freezer times are for best quality. When in doubt, throw it out."
    :calc="['engine' => 'fd-other', 'tool' => 'storage', 'fields' => ['food', 'place', 'state', 'stored'], 'data' => ['storage' => config('food_data.storage')]]"
    :how-to="[
        ['name' => 'Choose the food', 'text' => 'Grouped by FoodKeeper category.'],
        ['name' => 'Choose where and how it is stored', 'text' => ''],
        ['name' => 'Enter the date stored', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does raw chicken keep in the fridge?', 'answer' => '1–2 days (Chicken (whole): 1–2 days in the refrigerator from purchase (USDA FoodKeeper)).'],
        ['question' => 'How long in the freezer?', 'answer' => '12 months.'],
        ['question' => 'How long do leftovers keep?', 'answer' => '3–4 days.'],
    ]"
>
    <x-calc.select name="food" label="Food" :options="collect(config('food_data.storage'))->groupBy('category', true)->map(fn ($items) => $items->map(fn ($f) => $f['name'])->all())->all()" selected="407" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="place" label="Stored in" :options="['fridge' => 'Refrigerator', 'freezer' => 'Freezer', 'pantry' => 'Pantry']" selected="fridge" />
        <x-calc.select name="state" label="Package" :options="['unopened' => 'Unopened or fresh', 'opened' => 'Opened', 'thawed' => 'Thawed']" selected="unopened" />
        <x-calc.field name="stored" label="Stored on" value="2026-10-19" type="date" />
    </div>

    <x-calc.result label="Use by (longest time)" />

    <x-calc.options :decimals="false" :examples="[
        'Chicken fridge' => ['food' => '407', 'place' => 'fridge', 'state' => 'unopened', 'stored' => '2026-10-19'],
        'Chicken freezer' => ['food' => '407', 'place' => 'freezer', 'state' => 'unopened', 'stored' => '2026-10-19'],
        'Leftovers' => ['food' => '239', 'place' => 'fridge', 'state' => 'unopened', 'stored' => '2026-10-19'],
        'Eggs' => ['food' => '199', 'place' => 'fridge', 'state' => 'unopened', 'stored' => '2026-10-19'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Storage time'],
            'best' => ['label' => 'Shortest time'],
            'tip' => ['label' => 'Tip'],
        ]" />
        <x-calc.grid heading="All storage times" name="times" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>use by = date stored + FoodKeeper time</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
