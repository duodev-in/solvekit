<x-calc.page
    title="Cold Brew Ratio Calculator - SolveKit"
    description="Free cold brew ratio calculator: coffee and water for cold brew concentrate (1 : 4 or 1 : 5) or ready-to-drink cold brew (1 : 8), the yield after straining and servings after dilution."
    lede="Plan a batch of cold brew."
    about="Cold brew steeps coarse coffee in cold water for 12–24 hours. A concentrate uses 1 part coffee to 4–5 parts water by weight and is diluted about 1 : 1 with water or milk; ready-to-drink cold brew uses about 1 : 8. The wet grounds keep about 2 ml of water per gram of coffee, so the yield is less than the water you add (brewing guides)."
    :calc="['engine' => 'fd-drinks', 'tool' => 'cold_brew', 'fields' => ['style', 'known', 'amount', 'dilution']]"
    :how-to="[
        ['name' => 'Choose the style', 'text' => ''],
        ['name' => 'Enter coffee or water', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much water for 200 g of coffee as concentrate?', 'answer' => '1,000 ml (4¼ cups (4.23)), yielding 600 ml after straining.'],
        ['question' => 'How many servings is that?', 'answer' => '5.07 servings of 8 fl oz over ice.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="style" label="Style" :options="['strong' => 'Strong concentrate (1 : 4)', 'concentrate' => 'Concentrate (1 : 5)', 'ready' => 'Ready to drink (1 : 8)']" selected="concentrate" />
        <x-calc.select name="known" label="I know the" :options="['coffee' => 'Coffee (g)', 'water' => 'Water (ml)']" selected="coffee" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="200" min="0" step="any" />
        <x-calc.field name="dilution" label="Dilute concentrate 1 :" value="1" min="0" step="any" />
    </div>

    <x-calc.result label="Coarse ground coffee" />

    <x-calc.options :decimals="false" :examples="[
        'Concentrate' => ['style' => 'concentrate', 'known' => 'coffee', 'amount' => 200, 'dilution' => 1],
        'Ready to drink' => ['style' => 'ready', 'known' => 'water', 'amount' => 1000, 'dilution' => 1],
        'Strong 1 L' => ['style' => 'strong', 'known' => 'water', 'amount' => 1000, 'dilution' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water'],
            'yield' => ['label' => 'Yield'],
            'drink' => ['label' => 'After diluting'],
            'servings' => ['label' => 'Servings'],
            'steep' => ['label' => 'Steeping'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water = coffee × ratio</li>
            <li>yield ≈ water − 2 × coffee</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
