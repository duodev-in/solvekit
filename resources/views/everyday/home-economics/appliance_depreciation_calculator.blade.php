<x-calc.page
    title="Appliance Depreciation Calculator - SolveKit"
    description="Free appliance depreciation calculator: the current value of a refrigerator, washer, dryer or other appliance by straight-line or declining-balance depreciation over its typical life."
    lede="Work out what an appliance is worth now."
    about="Straight-line depreciation spreads the price (less any salvage value) evenly over the useful life; double-declining balance takes 2 ÷ life of the remaining value each year, so it drops faster early. Typical lives come from the NAHB study of home component life expectancy (2007): refrigerators 13 years, dishwashers 9, washers 10, dryers 13. Insurers and tax rules may use their own schedules."
    :calc="['engine' => 'ev-home', 'tool' => 'depreciation', 'fields' => ['appliance', 'life', 'price', 'age', 'salvage', 'method'], 'data' => ['appliance_life' => config('everyday_data.appliance_life')]]"
    :how-to="[
        ['name' => 'Choose the appliance', 'text' => 'Its typical life is filled in.'],
        ['name' => 'Enter price and age', 'text' => 'And a method.'],
    ]"
    :faqs="[
        ['question' => 'How long do refrigerators last?', 'answer' => 'About 13 years on average (NAHB).'],
        ['question' => 'What is a 4-year-old $1,800 fridge worth?', 'answer' => 'About $1,246 by straight-line depreciation over 13 years.'],
        ['question' => 'Which method should I use?', 'answer' => 'Straight line for simple estimates; declining balance reflects faster early loss.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="appliance" label="Appliance" :options="collect(config('everyday_data.appliance_life'))->map(fn ($a) => $a[0].' ('.$a[1].' years)')->all() + ['custom' => 'Other (enter life)']" selected="refrigerator" />
        <div data-show-when="appliance:custom" hidden>
            <x-calc.field name="life" label="Useful life" value="10" min="1" step="1" suffix="years" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Purchase price" value="1800" min="0" step="0.01" suffix="$" />
        <x-calc.field name="age" label="Age" value="4" min="0" step="0.5" suffix="years" />
        <x-calc.field name="salvage" label="Salvage value (optional)" value="" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.segmented name="method" legend="Method" :options="['straight' => 'Straight line', 'declining' => 'Declining balance']" selected="straight" />

    <x-calc.result label="Current value" />

    <x-calc.options :decimals="false" :examples="[
        'Fridge, 4 years old' => ['appliance' => 'refrigerator', 'life' => '', 'price' => 1800, 'age' => 4, 'salvage' => '', 'method' => 'straight'],
        'Washer, declining balance' => ['appliance' => 'washer', 'life' => '', 'price' => 900, 'age' => 3, 'salvage' => '', 'method' => 'declining'],
        'Other, 7-year life' => ['appliance' => 'custom', 'life' => 7, 'price' => 600, 'age' => 2.5, 'salvage' => 50, 'method' => 'straight'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lost' => ['label' => 'Value lost'],
            'yearly' => ['label' => 'Depreciation'],
            'left' => ['label' => 'Life left'],
        ]" />
        <x-calc.quick-ref heading="Value each year" name="schedule" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>straight line: value = price − (price − salvage) × age ÷ life</li>
            <li>declining: each year loses 2 ÷ life of the value left</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
