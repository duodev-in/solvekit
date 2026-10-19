<x-calc.page
    title="Party Drink Calculator - SolveKit"
    description="Free party drink calculator: how many drinks, bottles of wine, beer, spirits, soft drinks and ice a party needs from guests and hours, with the cost in your currency."
    lede="Plan drinks for a party."
    about="The usual rule is two drinks per guest in the first hour and one each hour after. A 750 ml bottle of wine pours five 5 oz glasses, a 750 ml bottle of spirits about sixteen 1½ oz drinks and a 2 L bottle eight 8 oz glasses. Allow 1 lb of ice per guest for drinks. Set the mix to suit your guests and include plenty of non-alcoholic options."
    :calc="['engine' => 'fd-party', 'tool' => 'party_drinks', 'fields' => ['guests', 'hours', 'beer', 'wine', 'spirits', 'soft', 'beer_price', 'wine_price', 'spirits_price', 'soft_price']]"
    :how-to="[
        ['name' => 'Enter guests and hours', 'text' => ''],
        ['name' => 'Set the drink mix and prices', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many drinks for 30 guests over 4 hours?', 'answer' => '150 drinks: wine 9 bottles (5 glasses each), beer 53 bottles or cans (3 cases).'],
        ['question' => 'What will it cost?', 'answer' => '$245.50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="guests" label="Guests" value="30" min="0" step="1" />
        <x-calc.field name="hours" label="Hours" value="4" min="0" step="any" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="beer" label="Beer" value="35" min="0" step="any" suffix="%" />
        <x-calc.field name="wine" label="Wine" value="30" min="0" step="any" suffix="%" />
        <x-calc.field name="spirits" label="Spirits" value="15" min="0" step="any" suffix="%" />
        <x-calc.field name="soft" label="Soft drinks" value="20" min="0" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="beer_price" label="Beer each" value="1.5" min="0" step="0.01" suffix="$" />
        <x-calc.field name="wine_price" label="Wine bottle" value="12" min="0" step="0.01" suffix="$" />
        <x-calc.field name="spirits_price" label="Spirits bottle" value="25" min="0" step="0.01" suffix="$" />
        <x-calc.field name="soft_price" label="Soft drink 2 L" value="2" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Drinks in all" />

    <x-calc.options :decimals="false" :examples="[
        'Party' => ['guests' => 30, 'hours' => 4, 'beer' => 35, 'wine' => 30, 'spirits' => 15, 'soft' => 20, 'beer_price' => 1.5, 'wine_price' => 12, 'spirits_price' => 25, 'soft_price' => 2],
        'Dry party' => ['guests' => 25, 'hours' => 3, 'beer' => 0, 'wine' => 0, 'spirits' => 0, 'soft' => 100, 'beer_price' => 1.5, 'wine_price' => 12, 'spirits_price' => 25, 'soft_price' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'beer' => ['label' => 'Beer'],
            'wine' => ['label' => 'Wine'],
            'spirits' => ['label' => 'Spirits'],
            'soft' => ['label' => 'Soft drinks'],
            'ice' => ['label' => 'Ice'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>drinks = guests × (2 + (hours − 1))</li>
            <li>wine bottles = wine drinks ÷ 5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
