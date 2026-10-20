<x-calc.page
    title="Roulette Payout Calculator - SolveKit"
    description="Free roulette payout calculator: payout, profit, chance and house edge for every bet on European and American wheels."
    lede="Find a roulette payout."
    about="Roulette pays a fixed ratio for each bet, set slightly below fair odds by the green zero (and double zero), which gives the house its edge."
    :calc="['engine' => 'st-prob', 'tool' => 'roulette', 'fields' => ['wheel', 'bet', 'stake'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does a straight-up bet pay?', 'answer' => '35 to 1; with a stake of 10 the payout is $360.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="wheel" label="Wheel" :options="['european' => 'European (single zero, 37 pockets)', 'american' => 'American (double zero, 38 pockets)']" selected="european" />
        <x-calc.select name="bet" label="Bet" :options="['straight' => 'Straight up (1 number)', 'split' => 'Split (2 numbers)', 'street' => 'Street (3 numbers)', 'corner' => 'Corner (4 numbers)', 'basket' => 'Top line / basket (0, 00, 1, 2, 3; American only)', 'sixline' => 'Six line (6 numbers)', 'dozen' => 'Dozen or column (12 numbers)', 'even' => 'Red/black, odd/even, 1–18/19–36 (18 numbers)']" selected="straight" />
        <x-calc.field name="stake" label="Stake" value="10" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Payout if it wins" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wheel' => 'european', 'bet' => 'straight', 'stake' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'profit' => ['label' => 'Profit if it wins'],
            'chance' => ['label' => 'Chance of winning'],
            'ev' => ['label' => 'Expected result per bet'],
            'edge' => ['label' => 'House edge'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
