<x-calc.page
    title="Money Weight Calculator - SolveKit"
    description="Free money weight calculator: how much an amount of cash weighs in US banknotes, US coins, euro coins or UK coins, with the stack height of notes."
    lede="Find out how much a pile of money weighs."
    about="Every US banknote weighs about 1 gram and is about 0.0043 in (0.11 mm) thick (Bureau of Engraving and Printing), so a million dollars in $100 notes weighs about 10 kg. Coin weights are the official specifications: US Mint, European Central Bank and Royal Mint."
    :calc="['engine' => 'ev-office', 'tool' => 'money_weight', 'fields' => ['amount', 'denomination'], 'data' => ['money' => config('everyday_data.money')]]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => 'In the currency of the note or coin.'],
        ['name' => 'Choose the note or coin', 'text' => 'Each has its official weight.'],
    ]"
    :faqs="[
        ['question' => 'How much does a million dollars weigh?', 'answer' => 'About 10 kg (22 lb) in $100 notes.'],
        ['question' => 'How much do 100 pennies weigh?', 'answer' => '250 g.'],
        ['question' => 'How much does a US note weigh?', 'answer' => 'About 1 gram, whatever its value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="1000000" min="0.01" step="any" />
        <x-calc.select name="denomination" label="In" :options="collect(config('everyday_data.money'))->map(fn ($m) => $m[0].' ('.$m[2].' g)')->all()" selected="usd_note_100" />
    </div>

    <x-calc.result label="Weight" />

    <x-calc.options :examples="[
        '$1 million in $100s' => ['amount' => 1000000, 'denomination' => 'usd_note_100'],
        '$100 in quarters' => ['amount' => 100, 'denomination' => 'usd_quarter'],
        '€50 in €2 coins' => ['amount' => 50, 'denomination' => 'eur_2'],
        '£20 in 1p coins' => ['amount' => 20, 'denomination' => 'gbp_001'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lb' => ['label' => 'In pounds'],
            'count' => ['label' => 'Count'],
            'stack' => ['label' => 'Stack'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = count × unit weight</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
