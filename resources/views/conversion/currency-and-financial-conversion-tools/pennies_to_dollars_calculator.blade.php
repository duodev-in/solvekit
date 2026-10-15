@php
    $coin = config('coins.penny');
@endphp

<x-calc.page
    title="Pennies to Dollars Calculator - SolveKit"
    description="Professional pennies to dollars calculator for coin conversion. Convert penny quantities to dollar amounts with detailed breakdown for counting and financial calculations."
    lede="Find the face value of pennies, or the metal value of copper and zinc pennies."
    about="Face value is the count times $0.01. Melt value is what the metal is worth: each coin's mass (from US Mint specifications) times the share of each metal, priced at the rates you enter. Metal prices change daily, so replace the example prices with today's."
    :calc="['engine' => 'coins', 'coin' => $coin, 'coinName' => 'pennies']"
    :how-to="[
        ['name' => 'Enter the number of pennies', 'text' => 'Whole coins only.'],
        ['name' => 'Pick the coin type', 'text' => 'Composition changed over the years, which matters for melt value.'],
        ['name' => 'Choose face or melt value', 'text' => 'For melt value, enter current metal prices.'],
    ]"
    :faqs="[
        ['question' => 'How many pennies make a dollar?', 'answer' => 'One hundred. A standard roll holds 50 pennies, which is 50 cents.'],
        ['question' => 'Are old pennies worth more as metal?', 'answer' => 'Pennies from 1982 and earlier are 95% copper and their metal is often worth more than one cent. Melting US coins is illegal, though.'],
        ['question' => 'How much does a penny weigh?', 'answer' => 'A zinc penny (1982 to present) weighs 2.5 g; a copper penny weighs 3.11 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.6fr)]">
        <x-calc.field name="count" label="Number of pennies" value="1000" min="0" step="1" placeholder="Count" />
        <x-calc.select name="type" label="Coin type" :options="collect($coin['types'])->map(fn ($type) => $type['name'])->all()" selected="zinc" />
    </div>

    <x-calc.segmented name="method" legend="Value" :options="['face' => 'Face value', 'melt' => 'Melt value']" selected="face" />

    <div data-show-when="method:melt" hidden class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="silver" label="Silver $/troy oz" value="30" min="0" step="0.01" />
        <x-calc.field name="copper" label="Copper $/lb" value="4.5" min="0" step="0.01" />
        <x-calc.field name="nickel" label="Nickel $/lb" value="7.5" min="0" step="0.01" />
        <x-calc.field name="zinc" label="Zinc $/lb" value="1.3" min="0" step="0.01" />
    </div>

    <x-calc.result label="Face value" />

    <x-calc.options :decimals="false" :examples="[
        'Jar of 2,500' => ['count' => 2500, 'type' => 'zinc', 'method' => 'face'],
        '1,000 copper pennies, melt' => ['count' => 1000, 'type' => 'copper', 'method' => 'melt'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'face' => ['label' => 'Face value'],
            'melt' => ['label' => 'Melt value'],
            'per_coin' => ['label' => 'Melt value per coin'],
            'weight' => ['label' => 'Total weight'],
            'silver' => ['label' => 'Silver content'],
            'composition' => ['label' => 'Composition'],
            'quarters' => ['label' => 'Same face value in quarters'],
            'dollars' => ['label' => 'Whole dollars'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>face value = count × $0.01</li>
            <li>melt = Σ mass × metal share × price</li>
            <li>1 troy oz = 31.1034768 g · 1 lb = 453.59237 g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
