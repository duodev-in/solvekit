<x-calc.page
    title="Quarantine Food Calculator - Coronavirus - SolveKit"
    description="Free emergency food supply calculator: the food energy and water a household needs to stay at home for a number of days (Ready.gov: 1 gallon of water per person per day), with an example shelf-stable shopping list."
    lede="Plan an emergency food and water supply."
    about="Ready.gov advises keeping at least a 3-day supply of food and water for evacuation and about two weeks at home, with one gallon of water per person per day for drinking and sanitation. Food energy uses your daily calories (about 2,000 kcal for adults and 1,400 for children is typical; USDA Dietary Guidelines give ranges by age and activity). The shopping list is one example split of shelf-stable staples using USDA energy values; adapt it to your diet."
    :calc="['engine' => 'fd-nutrition', 'tool' => 'quarantine', 'fields' => ['adults', 'kids', 'days', 'adult_kcal', 'kid_kcal', 'pets'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the household', 'text' => ''],
        ['name' => 'Enter the days and calories', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much water for a family of 4 for 2 weeks?', 'answer' => '56 gallons (212 L): 1 gallon a person a day.'],
        ['question' => 'How much food energy?', 'answer' => '95,200 kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="2" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="days" label="Days" value="14" min="0" step="1" />
        <x-calc.field name="adult_kcal" label="kcal a day per adult" value="2000" min="0" step="50" />
        <x-calc.field name="kid_kcal" label="kcal a day per child" value="1400" min="0" step="50" />
    </div>

    <x-calc.field name="pets" label="Pets" value="0" min="0" step="1" />

    <x-calc.result label="Food energy needed" />

    <x-calc.options :decimals="false" :examples="[
        'Two weeks' => ['adults' => 2, 'kids' => 2, 'days' => 14, 'adult_kcal' => 2000, 'kid_kcal' => 1400, 'pets' => 0],
        '3-day kit' => ['adults' => 1, 'kids' => 0, 'days' => 3, 'adult_kcal' => 2000, 'kid_kcal' => 1400, 'pets' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water'],
            'perDay' => ['label' => 'Per day'],
            'readyGov' => ['label' => 'Ready.gov'],
            'other' => ['label' => 'Also pack'],
        ]" />
        <x-calc.grid heading="Example shopping list" name="plan" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water = people × days × 1 gallon</li>
            <li>food = Σ kcal a day × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
