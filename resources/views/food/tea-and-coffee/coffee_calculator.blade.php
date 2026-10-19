<x-calc.page
    title="Coffee Calculator - SolveKit"
    description="Free coffee calculator: what your coffee habit costs a month, a year and over ten years, café or home-brewed, with caffeine a day, in your currency."
    lede="Find what your coffee habit costs."
    about="Yearly cost = cups a day × days a week × 52 × cost per cup. A café cup costs its price; a home cup costs the beans used (grams per cup × bag price ÷ bag weight) plus milk or extras. Caffeine comes from USDA FoodData Central (brewed coffee about 95 mg per 8 fl oz, a single espresso about 63 mg). General information, not medical advice."
    :calc="['engine' => 'fd-drinks', 'tool' => 'coffee_cost', 'fields' => ['mode', 'cups', 'days', 'brew', 'size', 'price', 'bag_price', 'bag_grams', 'grams_per_cup', 'extras'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Choose café or home', 'text' => ''],
        ['name' => 'Enter cups and prices', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do 2 café coffees a weekday cost a year?', 'answer' => '$2,340.00 at $4.50 each.'],
        ['question' => 'And brewing at home?', 'answer' => '$405.29 a year (about $0.78 a cup).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Where" :options="['cafe' => 'Café', 'home' => 'Home-brewed']" selected="cafe" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cups" label="Cups a day" value="2" min="0" step="any" />
        <x-calc.field name="days" label="Days a week" value="5" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="brew" label="Drink" :options="['coffee' => 'Brewed coffee', 'espresso' => 'Espresso drink (double shot)', 'instant' => 'Instant coffee']" selected="coffee" />
        <x-calc.select name="size" label="Cup size" :options="['8' => '8 fl oz', '12' => '12 fl oz', '16' => '16 fl oz', '20' => '20 fl oz']" selected="12" />
    </div>

    <div data-show-when="mode:cafe">
        <x-calc.field name="price" label="Price per cup" value="4.5" min="0" step="0.01" suffix="$" />
    </div>

    <div data-show-when="mode:home" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="bag_price" label="Bag price" value="12" min="0" step="0.01" suffix="$" />
            <x-calc.field name="bag_grams" label="Bag weight" value="340" min="0" step="any" suffix="g" />
        </div>
    </div>

    <div data-show-when="mode:home" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="grams_per_cup" label="Coffee per cup" value="15" min="0" step="any" suffix="g" />
            <x-calc.field name="extras" label="Milk and extras per cup" value="0.25" min="0" step="0.01" suffix="$" />
        </div>
    </div>

    <x-calc.result label="Coffee a year" />

    <x-calc.options :decimals="false" :examples="[
        'Café' => ['mode' => 'cafe', 'cups' => 2, 'days' => 5, 'brew' => 'coffee', 'size' => '12', 'price' => 4.5, 'bag_price' => 12, 'bag_grams' => 340, 'grams_per_cup' => 15, 'extras' => 0.25],
        'Home' => ['mode' => 'home', 'cups' => 2, 'days' => 5, 'brew' => 'coffee', 'size' => '12', 'price' => 4.5, 'bag_price' => 12, 'bag_grams' => 340, 'grams_per_cup' => 15, 'extras' => 0.25],
        'Daily latte' => ['mode' => 'cafe', 'cups' => 1, 'days' => 7, 'brew' => 'espresso', 'size' => '12', 'price' => 5.25, 'bag_price' => 12, 'bag_grams' => 340, 'grams_per_cup' => 15, 'extras' => 0.25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'month' => ['label' => 'A month'],
            'perCup' => ['label' => 'Per cup'],
            'beans' => ['label' => 'Coffee beans'],
            'caffeine' => ['label' => 'Caffeine'],
            'tenYears' => ['label' => 'Ten years'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>yearly = cups × days × 52 × cost per cup</li>
            <li>home cup = grams × bag price ÷ bag grams + extras</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
