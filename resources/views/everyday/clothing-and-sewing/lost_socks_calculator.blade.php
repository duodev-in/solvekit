<x-calc.page
    title="Lost Socks Calculator - SolveKit"
    description="Free lost socks calculator: how many socks you lose to the laundry each year from how many you wash and the chance of losing one."
    lede="Estimate how many socks go missing in your wash."
    about="Expected socks lost = socks washed a year × the chance a sock goes missing each wash. A tiny chance adds up: at 1 in 500 (0.2%) and 7 pairs a week, a household loses about 1.5 socks a year. Keeping pairs together in a mesh bag brings the chance close to zero."
    :calc="['engine' => 'ev-clothing', 'tool' => 'lost_socks', 'fields' => ['pairs', 'washes', 'chance', 'price']]"
    :how-to="[
        ['name' => 'Enter how many you wash', 'text' => 'Pairs a wash and washes a week.'],
        ['name' => 'Set the chance', 'text' => 'Your best guess of the odds.'],
    ]"
    :faqs="[
        ['question' => 'Where do lost socks go?', 'answer' => 'Under appliances, inside duvet covers, or left in machines.'],
        ['question' => 'How many socks will I lose?', 'answer' => 'About 1.5 a year at 7 pairs a week and a 0.2% chance for each sock in each wash.'],
        ['question' => 'How do I stop losing socks?', 'answer' => 'Wash them in a mesh bag.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pairs" label="Pairs washed a wash" value="7" min="1" step="1" />
        <x-calc.field name="washes" label="Washes a week" value="1" min="0.1" step="0.5" />
        <x-calc.field name="chance" label="Chance of losing a sock each wash" value="0.2" min="0" max="100" step="0.05" suffix="%" />
    </div>

    <x-calc.field name="price" label="Price per sock (optional)" value="3" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Socks lost" />

    <x-calc.options :examples="[
        '7 pairs a week, 0.2%' => ['pairs' => 7, 'washes' => 1, 'chance' => 0.2, 'price' => 3],
        'Family, 3 washes' => ['pairs' => 10, 'washes' => 3, 'chance' => 0.2, 'price' => 2],
        'Careless, 1%' => ['pairs' => 7, 'washes' => 1, 'chance' => 1, 'price' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'orphans' => ['label' => 'Odd socks'],
            'cost' => ['label' => 'Cost'],
            'months' => ['label' => 'How often'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lost = pairs × 2 × washes × 52.18 × chance</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
