<x-calc.page
    title="Wedding Alcohol Calculator - SolveKit"
    description="Free wedding alcohol calculator: bottles of wine, beer and spirits and sparkling wine for the toast, from guests, reception hours and your drink mix, with the cost in your currency."
    lede="Plan the bar for a wedding."
    about="Planners allow about one drink per guest per hour of reception. A 750 ml bottle of wine pours five glasses, a 750 ml bottle of spirits about sixteen 1½ oz drinks, and a bottle of sparkling wine eight toast glasses. Adjust the mix to your guests; many venues let you return unopened bottles."
    :calc="['engine' => 'fd-party', 'tool' => 'wedding_bar', 'fields' => ['guests', 'hours', 'wine', 'beer', 'spirits', 'toast', 'wine_price', 'beer_price', 'spirits_price']]"
    :how-to="[
        ['name' => 'Enter guests and hours', 'text' => ''],
        ['name' => 'Set the mix and prices', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much alcohol for 120 guests over 5 hours?', 'answer' => '600 drinks: wine 60 bottles (5 cases of 12), beer 180 bottles or cans (8 cases of 24), spirits 8 bottles of 750 ml.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="guests" label="Guests" value="120" min="0" step="1" />
        <x-calc.field name="hours" label="Reception hours" value="5" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wine" label="Wine" value="50" min="0" step="any" suffix="%" />
        <x-calc.field name="beer" label="Beer" value="30" min="0" step="any" suffix="%" />
        <x-calc.field name="spirits" label="Spirits" value="20" min="0" step="any" suffix="%" />
    </div>

    <x-calc.checkbox name="toast" label="Sparkling wine toast" :checked="true" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wine_price" label="Wine bottle" value="12" min="0" step="0.01" suffix="$" />
        <x-calc.field name="beer_price" label="Beer each" value="1.5" min="0" step="0.01" suffix="$" />
        <x-calc.field name="spirits_price" label="Spirits bottle" value="25" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Drinks to plan for" />

    <x-calc.options :decimals="false" :examples="[
        '120 guests' => ['guests' => 120, 'hours' => 5, 'wine' => 50, 'beer' => 30, 'spirits' => 20, 'toast' => true, 'wine_price' => 12, 'beer_price' => 1.5, 'spirits_price' => 25],
        'Wine and beer only' => ['guests' => 80, 'hours' => 4, 'wine' => 60, 'beer' => 40, 'spirits' => 0, 'toast' => false, 'wine_price' => 10, 'beer_price' => 1.25, 'spirits_price' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'wine' => ['label' => 'Wine'],
            'beer' => ['label' => 'Beer'],
            'spirits' => ['label' => 'Spirits'],
            'toast' => ['label' => 'Toast'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>drinks = guests × hours</li>
            <li>wine bottles = wine drinks ÷ 5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
