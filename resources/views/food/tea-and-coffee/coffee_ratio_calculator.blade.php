<x-calc.page
    title="Coffee Ratio Calculator - SolveKit"
    description="Free coffee ratio calculator: grams of coffee and water for drip, pour-over, French press, AeroPress, moka pot and espresso, by cups and strength, with scoops and tablespoons."
    lede="Find how much coffee to use for your brew method."
    about="Brew strength is set by the ratio of water to coffee by weight. The Specialty Coffee Association's Golden Cup standard is 55 g of coffee per litre (about 1 : 18); most people brew between 1 : 15 (strong) and 1 : 18 (mild). Immersion methods like the French press use a little more coffee; a moka pot makes a concentrated 1 : 7 to 1 : 10 brew; espresso is described by dose : yield (1 : 2 is a normale shot). A coffee scoop is 2 tablespoons, about 10 g of ground coffee."
    :calc="['engine' => 'fd-drinks', 'tool' => 'coffee_ratio', 'fields' => ['mode', 'method', 'strength', 'cups', 'cup_size', 'shots', 'known', 'amount', 'ratio']]"
    :how-to="[
        ['name' => 'Choose the brew method and strength', 'text' => ''],
        ['name' => 'Enter the cups', 'text' => 'Or switch to a ratio of your own.'],
    ]"
    :faqs="[
        ['question' => 'How much coffee for 4 cups of drip coffee?', 'answer' => '55.7 g (5.57 coffee scoops (2 tbsp, about 10 g each)).'],
        ['question' => 'How much for a French press of 4 cups?', 'answer' => '67.6 g.'],
        ['question' => 'What dose for a double espresso?', 'answer' => '18 g in, 36 g out (1 : 2).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Work out" :options="['method' => 'By brew method', 'ratio' => 'From a ratio']" selected="method" />

    <div data-show-when="mode:method">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="method" label="Method" :options="['drip' => 'Drip machine', 'pourover' => 'Pour-over (V60, Chemex)', 'french' => 'French press', 'aeropress' => 'AeroPress', 'moka' => 'Moka pot', 'espresso' => 'Espresso']" selected="drip" />
            <x-calc.select name="strength" label="Strength" :options="['strong' => 'Strong', 'medium' => 'Medium', 'mild' => 'Mild']" selected="medium" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:method">
            <x-calc.field name="cups" label="Cups" value="4" min="0" step="1" />
        </div>
        <div data-show-when="mode:method">
            <x-calc.select name="cup_size" label="Cup size" :options="['6' => '6 fl oz (coffee-maker cup)', '8' => '8 fl oz', '12' => '12 fl oz (mug)', '16' => '16 fl oz', '20' => '20 fl oz']" selected="8" />
        </div>
    </div>

    <div data-show-when="mode:method">
        <x-calc.field name="shots" label="Espresso shots (for espresso)" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:ratio" hidden>
            <x-calc.select name="known" label="I know the" :options="['water' => 'Water (ml)', 'coffee' => 'Coffee (g)']" selected="water" />
        </div>
        <div data-show-when="mode:ratio" hidden>
            <x-calc.field name="amount" label="Amount" value="500" min="0" step="any" />
        </div>
        <div data-show-when="mode:ratio" hidden>
            <x-calc.field name="ratio" label="Ratio 1 :" value="16" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Ground coffee" />

    <x-calc.options :decimals="false" :examples="[
        'Drip 4 cups' => ['mode' => 'method', 'method' => 'drip', 'strength' => 'medium', 'cups' => 4, 'cup_size' => '8', 'shots' => 2, 'known' => 'water', 'amount' => 500, 'ratio' => 16],
        'French press' => ['mode' => 'method', 'method' => 'french', 'strength' => 'medium', 'cups' => 4, 'cup_size' => '8', 'shots' => 2, 'known' => 'water', 'amount' => 500, 'ratio' => 16],
        'Espresso' => ['mode' => 'method', 'method' => 'espresso', 'strength' => 'medium', 'cups' => 4, 'cup_size' => '8', 'shots' => 2, 'known' => 'water', 'amount' => 500, 'ratio' => 16],
        'Strong pour-over' => ['mode' => 'method', 'method' => 'pourover', 'strength' => 'strong', 'cups' => 2, 'cup_size' => '12', 'shots' => 2, 'known' => 'water', 'amount' => 500, 'ratio' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water'],
            'ratio' => ['label' => 'Ratio'],
            'scoops' => ['label' => 'Scoops'],
            'tbsp' => ['label' => 'Tablespoons'],
            'brewed' => ['label' => 'Brewed coffee'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coffee g = water ml ÷ ratio</li>
            <li>SCA Golden Cup: 55 g per litre</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
