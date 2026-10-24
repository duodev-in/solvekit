<x-calc.page
    title="Matched Betting Calculator - SolveKit"
    description="Free matched betting calculator: lay stake, liability and profit for qualifying and free bets."
    lede="Work out a lay stake."
    about="Matched betting backs and lays the same outcome so the result is nearly the same whoever wins."
    :calc="['engine' => 'ot-misc', 'tool' => 'matched_betting', 'fields' => ['type', 'stake', 'back', 'lay', 'commission'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What lay stake matches the example?', 'answer' => '$19.48.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Bet" :options="['qualifying' => 'Qualifying bet (your own money)', 'snr' => 'Free bet, stake not returned', 'sr' => 'Free bet, stake returned']" selected="qualifying" />
        <x-calc.field name="stake" label="Back stake" value="20" min="0" step="any" suffix="$" />
        <x-calc.field name="back" label="Back odds (decimal)" value="3" min="1" step="any" />
        <x-calc.field name="lay" label="Lay odds (decimal)" value="3.1" min="1" step="any" />
        <x-calc.field name="commission" label="Exchange commission (%)" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Lay stake" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'qualifying', 'stake' => 20, 'back' => 3, 'lay' => 3.1, 'commission' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'liability' => ['label' => 'Liability (needed in the exchange)'],
            'ifBack' => ['label' => 'Profit if the back bet wins'],
            'ifLay' => ['label' => 'Profit if the lay bet wins'],
            'retention' => ['label' => 'Free-bet value kept'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
