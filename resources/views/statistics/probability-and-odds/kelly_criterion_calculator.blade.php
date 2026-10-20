<x-calc.page
    title="Kelly Criterion Calculator - SolveKit"
    description="Free Kelly criterion calculator: the share of your bankroll to bet for given odds and win probability, with half-Kelly."
    lede="Size a bet with the Kelly criterion."
    about="The Kelly criterion picks the bet size that maximises long-run growth: f* = (bp − q) ÷ b. It only works if your probability is right."
    :calc="['engine' => 'st-prob', 'tool' => 'kelly', 'fields' => ['odds', 'p', 'bank'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does Kelly stake at 2.5 odds with a 45% chance?', 'answer' => '8.333% of the bankroll.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="odds" label="Odds offered (2.5, 3/2 or +150)" value="2.5" type="text" inputmode="text" />
        <x-calc.field name="p" label="Your chance of winning (%)" value="45" min="0" step="any" />
        <x-calc.field name="bank" label="Bankroll" value="1000" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Kelly stake (share of bankroll)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['odds' => '2.5', 'p' => 45, 'bank' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'stake' => ['label' => 'Stake'],
            'half' => ['label' => 'Half-Kelly stake'],
            'edge' => ['label' => 'Your edge (expected profit per 1 staked)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
