<x-calc.page
    title="Coin Toss Streak Calculator - SolveKit"
    description="Free coin toss streak calculator: the exact probability of a run of k heads (or either side) in n flips, and the expected longest streak."
    lede="Find the chance of a streak."
    about="Long streaks are more common than people expect. This page computes the exact chance with a recurrence over the current run length, not a simulation."
    :calc="['engine' => 'st-prob', 'tool' => 'coin_streak', 'fields' => ['n', 'k', 'side', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance of 7 heads in a row in 100 flips?', 'answer' => '0.31752.'],
        ['question' => 'What is the expected longest run of heads?', 'answer' => '5.9918.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Number of flips" value="100" min="1" step="any" />
        <x-calc.field name="k" label="Streak length" value="7" min="1" step="any" />
        <x-calc.select name="side" label="Streak of" :options="['heads' => 'Heads only', 'either' => 'Either side (all heads or all tails)']" selected="heads" />
        <x-calc.field name="p" label="P(heads) on one flip" value="0.5" min="0" step="any" />
    </div>

    <x-calc.result label="P(a streak of at least k)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 100, 'k' => 7, 'side' => 'heads', 'p' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'none' => ['label' => 'P(no such streak)'],
            'expected' => ['label' => 'Expected longest streak'],
            'median' => ['label' => 'Most likely longest streak'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
