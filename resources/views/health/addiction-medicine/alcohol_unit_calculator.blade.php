<x-calc.page
    title="Alcohol Unit Calculator - SolveKit"
    description="Free alcohol unit calculator: UK units, grams of alcohol and US standard drinks in your drinks, against the 14-units-a-week guideline."
    lede="Count units of alcohol."
    about="One UK unit is 10 ml (8 g) of pure alcohol: units = volume (ml) × ABV (%) ÷ 1,000. The UK Chief Medical Officers advise no more than 14 units a week, spread over three or more days. A pint of 4.5% beer is about 2.6 units and a 250 ml glass of 13% wine 3.3. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'alcohol_units', 'fields' => ['drinks'], 'country' => 'uk']"
    :how-to="[
        ['name' => 'List the drinks', 'text' => 'Volume and strength are on the label.'],
    ]"
    :faqs="[
        ['question' => 'How many units are two pints of 4.5% beer and a large glass of wine?', 'answer' => '8.4 units.'],
    ]"
>
    <x-calc.rows-editor name="drinks" label="Drinks (name, ml, % ABV, how many)" :columns="['name' => 'Drink', 'ml' => 'ml', 'abv' => '% ABV', 'count' => 'How many']" :rows="[['Beer, pint (568 ml)', '568', '4.5', '2'], ['Wine, large glass', '250', '13', '1']]" add-label="Add drink" :text="['name', 'ml', 'abv', 'count']" />

    <x-calc.result label="UK units of alcohol" />

    <x-calc.options :decimals="false" :examples="[
        'Night out' => ['drinks' => 'Beer, pint (568 ml)	568	4.5	2
Wine, large glass	250	13	1'],
        'Spirits' => ['drinks' => 'Gin and tonic (25 ml gin)	25	40	3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'grams' => ['label' => 'Pure alcohol'],
            'units' => ['label' => 'UK units'],
            'us' => ['label' => 'US standard drinks'],
            'guideline' => ['label' => 'Guideline'],
        ]" />
        <x-calc.grid heading="Drinks" name="drinks" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>units = ml × ABV ÷ 1,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
