<x-calc.page
    title="Standard Drink Calculator - SolveKit"
    description="Free standard drink calculator: how many standard drinks are in your drinks, by the US, UK, Australian, Canadian, Indian, WHO and other definitions."
    lede="Count standard drinks."
    about="A standard drink is a fixed amount of pure alcohol that varies by country: 14 g in the US (NIAAA), 10 g in Australia and by WHO, 13.45 g in Canada and 8 g for a UK unit. Grams = ml × ABV ÷ 100 × 0.789 (the density of ethanol). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'alcohol_units', 'fields' => ['drinks', 'country'], 'mode' => 'standard']"
    :how-to="[
        ['name' => 'List the drinks', 'text' => ''],
        ['name' => 'Choose the country\'s definition', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many US standard drinks are a 12 oz beer and a 5 oz glass of wine?', 'answer' => '2.0.'],
    ]"
>
    <x-calc.rows-editor name="drinks" label="Drinks (name, ml, % ABV, how many)" :columns="['name' => 'Drink', 'ml' => 'ml', 'abv' => '% ABV', 'count' => 'How many']" :rows="[['Beer, 12 oz', '355', '5', '1'], ['Wine, 5 oz', '148', '12', '1']]" add-label="Add drink" :text="['name', 'ml', 'abv', 'count']" />

    <x-calc.select name="country" label="Definition" :options="['us' => 'United States (14 g)', 'uk' => 'United Kingdom unit (8 g)', 'au' => 'Australia (10 g)', 'ca' => 'Canada (13.45 g)', 'in' => 'India (10 g)', 'who' => 'WHO (10 g)', 'ie' => 'Ireland (10 g)', 'nz' => 'New Zealand (10 g)']" selected="us" />

    <x-calc.result label="Standard drinks" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['drinks' => 'Beer, 12 oz	355	5	1
Wine, 5 oz	148	12	1', 'country' => 'us'],
        'Australia' => ['drinks' => 'Schooner of beer	425	4.8	2', 'country' => 'au'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'grams' => ['label' => 'Pure alcohol'],
            'units' => ['label' => 'UK units'],
            'us' => ['label' => 'US standard drinks'],
            'guideline' => ['label' => 'Definition'],
        ]" />
        <x-calc.grid heading="Drinks" name="drinks" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grams = ml × ABV ÷ 100 × 0.789</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
