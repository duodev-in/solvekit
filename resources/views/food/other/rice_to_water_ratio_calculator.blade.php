<x-calc.page
    title="Rice to Water Ratio Calculator - SolveKit"
    description="Free rice to water ratio calculator: how much water for white, basmati, jasmine, brown, parboiled or wild rice on the stove, in a rice cooker or an Instant Pot, with cooking time and yield."
    lede="Find how much water to cook rice."
    about="Water ratios differ by rice and method: long-grain white rice takes about 2 cups of water per cup on the stove, basmati 1½, jasmine 1¼, brown 2¼ and wild rice 3. Rice cookers lose less steam and pressure cookers almost none, so they need less. These are package and USA Rice Federation ratios; your pot and taste may call for a little more or less. Yields come from USDA cooked and raw weights."
    :calc="['engine' => 'fd-other', 'tool' => 'rice_water', 'fields' => ['type', 'amount', 'method'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Choose the rice and amount', 'text' => ''],
        ['name' => 'Choose the method', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much water for 1 cup of white rice?', 'answer' => '2 cups on the stove.'],
        ['question' => 'Basmati in an Instant Pot?', 'answer' => '2 cups for 2 cups.'],
        ['question' => 'Brown rice?', 'answer' => '2¼ cups for 1 cup (40–45 min, then 10 min off the heat).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="type" label="Rice" :options="['long' => 'White long-grain', 'basmati' => 'Basmati', 'jasmine' => 'Jasmine', 'medium' => 'White medium-grain', 'short' => 'Short-grain (sushi)', 'brown' => 'Brown', 'parboiled' => 'Parboiled', 'wild' => 'Wild']" selected="long" />
        <x-calc.field name="amount" label="Rice" value="1" min="0" step="any" suffix="cups" />
        <x-calc.select name="method" label="Method" :options="['stove' => 'Stovetop', 'cooker' => 'Rice cooker', 'pot' => 'Instant Pot (pressure)']" selected="stove" />
    </div>

    <x-calc.result label="Water" />

    <x-calc.options :decimals="false" :examples="[
        'White stovetop' => ['type' => 'long', 'amount' => 1, 'method' => 'stove'],
        'Basmati Instant Pot' => ['type' => 'basmati', 'amount' => 2, 'method' => 'pot'],
        'Brown' => ['type' => 'brown', 'amount' => 1, 'method' => 'stove'],
        'Sushi rice cooker' => ['type' => 'short', 'amount' => 3, 'method' => 'cooker'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Ratio'],
            'time' => ['label' => 'Time'],
            'yield' => ['label' => 'Cooked rice'],
            'rinse' => ['label' => 'Rinsing'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water = rice × ratio</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
