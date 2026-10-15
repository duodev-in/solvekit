@php
    $coin = config('coins.nickel');
@endphp

<x-calc.page
    title="Nickels to Dollars Calculator - SolveKit"
    description="Professional nickels to dollars calculator for coin conversion. Convert nickel quantities to dollar amounts with detailed breakdown for counting and financial calculations."
    lede="Find the face value of nickels, or their melt value in copper, nickel and silver."
    about="Face value is the count times $0.05. Melt value is what the metal is worth: each coin's mass (from US Mint specifications) times the share of each metal, priced at the rates you enter. Metal prices change daily, so replace the example prices with today's."
    :calc="['engine' => 'coins', 'coin' => $coin, 'coinName' => 'nickels']"
    :how-to="[
        ['name' => 'Enter the number of nickels', 'text' => 'Whole coins only.'],
        ['name' => 'Pick the coin type', 'text' => 'Composition changed over the years, which matters for melt value.'],
        ['name' => 'Choose face or melt value', 'text' => 'For melt value, enter current metal prices.'],
    ]"
    :faqs="[
        ['question' => 'How many nickels make a dollar?', 'answer' => 'Twenty. A standard roll holds 40 nickels, which is $2.'],
        ['question' => 'Are any nickels silver?', 'answer' => 'Wartime nickels from 1942 to 1945 contain 35% silver, about 0.0563 troy ounces each. They have a large mint mark above Monticello.'],
        ['question' => 'What is a nickel made of?', 'answer' => '75% copper and 25% nickel, weighing 5 grams.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.6fr)]">
        <x-calc.field name="count" label="Number of nickels" value="200" min="0" step="1" placeholder="Count" />
        <x-calc.select name="type" label="Coin type" :options="collect($coin['types'])->map(fn ($type) => $type['name'])->all()" selected="jefferson" />
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
        'Roll of 40' => ['count' => 40, 'type' => 'jefferson', 'method' => 'face'],
        '50 wartime nickels, melt' => ['count' => 50, 'type' => 'wartime', 'method' => 'melt'],
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
            <li>face value = count × $0.05</li>
            <li>melt = Σ mass × metal share × price</li>
            <li>1 troy oz = 31.1034768 g · 1 lb = 453.59237 g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
