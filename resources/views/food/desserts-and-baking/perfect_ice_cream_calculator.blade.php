<x-calc.page
    title="Perfect Ice Cream Calculator - SolveKit"
    description="Free ice cream mix calculator: fat, milk solids, sugars, total solids, sweetness (POD) and softness (PAC) of your ice cream base from its ingredients, against the usual target ranges."
    lede="Balance an ice cream base."
    about="Smooth ice cream depends on the mix: about 10–16% fat, 9–12% milk solids-not-fat (MSNF), 12–18% sugars and 36–42% total solids (ice cream technology texts). Compositions come from USDA FoodData Central. POD (sweetness) and PAC (freezing-point depression) compare sugars with sucrose: honey is sweeter and softens more, corn syrup is less sweet and softens less, lactose is barely sweet. Use them to compare versions of a recipe. Too little solids gives icy ice cream, too much a sandy or gummy texture."
    :calc="['engine' => 'fd-bake', 'tool' => 'ice_cream', 'fields' => ['mix'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'List the ingredients and grams', 'text' => 'Pick names from the list so the USDA composition is found.'],
        ['name' => 'Read the balance', 'text' => 'Adjust cream, milk powder or sugar to bring values into range.'],
    ]"
    :faqs="[
        ['question' => 'Is milk 500 g, cream 300 g, sugar 150 g, 4 yolks and 30 g milk powder balanced?', 'answer' => 'Outside the usual range: MSNF low.'],
        ['question' => 'What is the fat content?', 'answer' => '13.8% (10–16%: in range).'],
    ]"
>
    <x-calc.rows-editor name="mix" label="Ingredients (name, grams)" :columns="['name' => 'Ingredient', 'grams' => 'Grams']" :rows="[['Whole milk', '500'], ['Heavy cream', '300'], ['Granulated sugar', '150'], ['Egg yolk', '80'], ['Nonfat dry milk powder', '30']]" add-label="Add ingredient" :text="['name', 'grams']" :lists="['name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <x-calc.result label="Total solids" />

    <x-calc.options :decimals="false" :examples="[
        'Custard base' => ['mix' => 'Whole milk	500
Heavy cream	300
Granulated sugar	150
Egg yolk	80
Nonfat dry milk powder	30'],
        'Philadelphia (no eggs)' => ['mix' => 'Whole milk	400
Heavy cream	500
Granulated sugar	150'],
        'Too lean' => ['mix' => 'Whole milk	800
Granulated sugar	120'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fat' => ['label' => 'Fat'],
            'msnf' => ['label' => 'Milk solids-not-fat'],
            'sugars' => ['label' => 'Added sugars'],
            'solids' => ['label' => 'Total solids'],
            'pod' => ['label' => 'POD'],
            'pac' => ['label' => 'PAC'],
            'mass' => ['label' => 'Mix weight'],
        ]" />
        <x-calc.grid heading="Ingredients" name="lines" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fat % = Σ fat ÷ mix</li>
            <li>solids % = Σ (100 − water) ÷ mix</li>
            <li>MSNF = dairy solids − fat</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
