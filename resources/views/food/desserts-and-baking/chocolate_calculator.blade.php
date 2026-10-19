<x-calc.page
    title="Chocolate Calculator - SolveKit"
    description="Free chocolate calculator: ganache ratios for glaze, frosting and truffles, tempering temperatures for dark, milk and white chocolate, and blending two chocolates to a target cocoa percentage."
    lede="Ganache, tempering and blending chocolate."
    about="Ganache is chocolate and cream by weight: more cream for a pourable glaze, more chocolate for truffles, and more chocolate again for milk and white chocolate, which hold less cocoa solids (pastry conventions). Tempering melts, cools and rewarms chocolate so it sets glossy and snaps; the temperatures are typical couverture makers' curves, so follow the maker's own curve when given. Blending two chocolates to a target percentage is a weighted average."
    :calc="['engine' => 'fd-bake', 'tool' => 'chocolate', 'fields' => ['mode', 'type', 'weight', 'use', 'cocoa_a', 'cocoa_b', 'target']]"
    :how-to="[
        ['name' => 'Choose the task', 'text' => ''],
        ['name' => 'Enter the chocolate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much cream for 200 g of dark chocolate frosting?', 'answer' => 'Frosting or filling: 1.5 : 1 chocolate to cream for dark chocolate: 133 g.'],
        ['question' => 'What are the tempering temperatures for milk chocolate?', 'answer' => '29–30 °C working (melt 40–45 °C (104–113 °F), cool 26–27 °C (79–81 °F)).'],
        ['question' => 'How do I make 70% from 85% and 55%?', 'answer' => '150 g of 85% + 150 g of 55% chocolate = 300 g at 70%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Task" :options="['ganache' => 'Ganache', 'temper' => 'Tempering', 'blend' => 'Blend']" selected="ganache" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Chocolate" :options="['dark' => 'Dark', 'milk' => 'Milk', 'white' => 'White']" selected="dark" />
        <x-calc.field name="weight" label="Chocolate weight" value="200" min="0" step="any" suffix="g" />
    </div>

    <div data-show-when="mode:ganache">
        <x-calc.select name="use" label="Use" :options="['glaze' => 'Glaze or drip', 'frosting' => 'Frosting or filling', 'truffles' => 'Truffles']" selected="frosting" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:blend" hidden>
            <x-calc.field name="cocoa_a" label="First chocolate" value="85" min="0" max="100" suffix="%" />
        </div>
        <div data-show-when="mode:blend" hidden>
            <x-calc.field name="cocoa_b" label="Second chocolate" value="55" min="0" max="100" suffix="%" />
        </div>
        <div data-show-when="mode:blend" hidden>
            <x-calc.field name="target" label="Target" value="70" min="0" max="100" suffix="%" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Ganache' => ['mode' => 'ganache', 'type' => 'dark', 'weight' => 200, 'use' => 'frosting', 'cocoa_a' => 85, 'cocoa_b' => 55, 'target' => 70],
        'Temper milk' => ['mode' => 'temper', 'type' => 'milk', 'weight' => 400, 'use' => 'frosting', 'cocoa_a' => 85, 'cocoa_b' => 55, 'target' => 70],
        'Blend' => ['mode' => 'blend', 'type' => 'dark', 'weight' => 300, 'use' => 'frosting', 'cocoa_a' => 85, 'cocoa_b' => 55, 'target' => 70],
        'White truffles' => ['mode' => 'ganache', 'type' => 'white', 'weight' => 300, 'use' => 'truffles', 'cocoa_a' => 85, 'cocoa_b' => 55, 'target' => 70],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:ganache">
            <x-calc.rows heading="Details" :rows="[
                'cream' => ['label' => 'Cream'],
                'ratio' => ['label' => 'Ratio'],
                'total' => ['label' => 'Ganache'],
                'method' => ['label' => 'Method'],
            ]" />
        </div>
        <div data-show-when="mode:temper" hidden>
            <x-calc.rows heading="Details" :rows="[
                'melt' => ['label' => 'Melt to'],
                'cool' => ['label' => 'Cool to'],
                'work' => ['label' => 'Rewarm to'],
                'seed' => ['label' => 'Seeding'],
            ]" />
        </div>
        <div data-show-when="mode:blend" hidden>
            <x-calc.rows heading="Details" :rows="[
                'first' => ['label' => 'First chocolate'],
                'second' => ['label' => 'Second chocolate'],
                'shares' => ['label' => 'Shares'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cream = chocolate ÷ ratio</li>
            <li>blend: A share = (target − B) ÷ (A − B)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
