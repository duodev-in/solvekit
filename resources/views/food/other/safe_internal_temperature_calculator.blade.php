<x-calc.page
    title="Safe Internal Temperature Calculator - SolveKit"
    description="Free safe internal temperature chart: USDA safe minimum internal temperatures for beef, pork, poultry, ground meat, ham, eggs, fish, shellfish and leftovers, in °F and °C, with rest times."
    lede="Look up the safe cooking temperature for any food."
    about="USDA FSIS safe minimum internal temperatures: 145 °F (63 °C) with a 3-minute rest for whole cuts of beef, pork, veal and lamb and for fish; 160 °F (71 °C) for ground meats and egg dishes; 165 °F (74 °C) for all poultry, stuffing, casseroles and leftovers. Colour is not a reliable sign: measure with a food thermometer in the thickest part, away from bone. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-other', 'tool' => 'safe_temp', 'fields' => ['food'], 'data' => ['safe' => config('food_data.safe')]]"
    :how-to="[
        ['name' => 'Choose the food', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What temperature is chicken safe at?', 'answer' => '165 °F (74 °C. Check the thigh, wing and thickest part of the breast.).'],
        ['question' => 'What about pork chops?', 'answer' => '145 °F; 63 °C, then rest 3 minutes. Pork cooked to 145 °F may still look pink..'],
        ['question' => 'And ground beef?', 'answer' => '160 °F.'],
    ]"
>
    <x-calc.select name="food" label="Food" :options="collect(config('food_data.safe'))->groupBy(0, true)->map(fn ($rows) => $rows->map(fn ($r) => $r[1])->all())->all()" selected="0" />

    <x-calc.result label="Safe minimum temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Ground beef' => ['food' => '0'],
        'Poultry' => ['food' => '3'],
        'Pork' => ['food' => '5'],
        'Fish' => ['food' => '9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'c' => ['label' => 'Celsius'],
            'rest' => ['label' => 'Rest'],
            'group' => ['label' => 'Group'],
            'how' => ['label' => 'How to check'],
        ]" />
        <x-calc.grid heading="USDA chart" name="chart" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>USDA FSIS chart</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
