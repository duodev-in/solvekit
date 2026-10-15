@php
    $coin = config('coins.dime');
@endphp

<x-calc.page
    title="Dimes to Dollars Calculator - SolveKit"
    description="Professional dimes to dollars calculator for coin conversion. Convert dime quantities to dollar amounts with detailed breakdown for counting and financial calculations."
    lede="Find the face value of a pile of dimes, or the melt value of silver dimes."
    about="Face value is the count times $0.10. Melt value is what the metal is worth: each coin's mass (from US Mint specifications) times the share of each metal, priced at the rates you enter. Metal prices change daily, so replace the example prices with today's."
    :calc="['engine' => 'coins', 'coin' => $coin, 'coinName' => 'dimes']"
    :how-to="[
        ['name' => 'Enter the number of dimes', 'text' => 'Whole coins only.'],
        ['name' => 'Pick the coin type', 'text' => 'Composition changed over the years, which matters for melt value.'],
        ['name' => 'Choose face or melt value', 'text' => 'For melt value, enter current metal prices.'],
    ]"
    :faqs="[
        ['question' => 'How many dimes make a dollar?', 'answer' => 'Ten. A standard roll holds 50 dimes, which is $5.'],
        ['question' => 'Which dimes are silver?', 'answer' => 'Dimes dated 1964 and earlier are 90% silver, about 0.0723 troy ounces each. From 1965 they are copper-nickel clad.'],
        ['question' => 'Is a modern dime worth more than 10 cents as metal?', 'answer' => 'No. A clad dime contains well under a cent of copper and nickel.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.6fr)]">
        <x-calc.field name="count" label="Number of dimes" value="250" min="0" step="1" placeholder="Count" />
        <x-calc.select name="type" label="Coin type" :options="collect($coin['types'])->map(fn ($type) => $type['name'])->all()" selected="clad" />
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
        'Roll of 50' => ['count' => 50, 'type' => 'clad', 'method' => 'face'],
        '100 silver dimes, melt' => ['count' => 100, 'type' => 'silver', 'method' => 'melt'],
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
            <li>face value = count × $0.10</li>
            <li>melt = Σ mass × metal share × price</li>
            <li>1 troy oz = 31.1034768 g · 1 lb = 453.59237 g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
