<x-calc.page
    title="Poker Odds Calculator - SolveKit"
    description="Free poker odds calculator: Texas Hold’em win, tie and lose chances against known or random hands."
    lede="Find your poker odds."
    about="Your equity is the share of possible runouts where your hand wins."
    :calc="['engine' => 'ot-play', 'tool' => 'poker_odds', 'fields' => ['hero', 'board', 'known', 'randoms', 'seed'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What are A♥K♥ odds against Q♠Q♦ on Q♥7♥2♣?', 'answer' => '25.56% to win.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hero" label="Your cards (e.g. As Kd)" value="Ah Kh" type="text" inputmode="text" />
        <x-calc.field name="board" label="Board cards (0, 3, 4 or 5)" value="Qh 7h 2c" type="text" inputmode="text" />
        <x-calc.textarea name="known" label="Known opponent hands (one per line, optional)" value="Qs Qd" rows="3" />
        <x-calc.field name="randoms" label="Opponents with unknown cards" value="0" min="0" step="any" />
        <x-calc.field name="seed" label="Simulation seed" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="Chance to win" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hero' => 'Ah Kh', 'board' => 'Qh 7h 2c', 'known' => 'Qs Qd', 'randoms' => 0, 'seed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tie' => ['label' => 'Chance to tie (share of the pot)'],
            'lose' => ['label' => 'Chance to lose'],
            'current' => ['label' => 'Your hand now'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
