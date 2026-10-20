<x-calc.page
    title="Lottery Calculator - SolveKit"
    description="Free lottery calculator: odds of winning the jackpot and every prize tier for Powerball, Mega Millions, EuroMillions, UK Lotto or any lottery. Includes practice questions."
    lede="Find your lottery odds."
    about="Lottery odds come from counting combinations: choosing k numbers from n can be done C(n, k) ways, and bonus balls multiply the count."
    :calc="['engine' => 'st-prob', 'tool' => 'lottery', 'fields' => ['mode', 'format', 'k', 'n', 'k2', 'n2', 'tickets', 'price', 'question', 'answer'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'statistics' => collect(config('statistics_data'))->only(['lotteries'])->all()], 'currency' => 'USD', 'practice' => 'lottery']"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the odds of a 6-from-49 jackpot?', 'answer' => '1 in 13,983,816.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered lottery-odds problems with the working. This replaces the old lottery quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="format" label="Lottery" :options="['powerball' => 'Powerball (US): 5 of 69 + 1 of 26', 'mega_millions' => 'Mega Millions (US): 5 of 70 + 1 of 24', 'euromillions' => 'EuroMillions: 5 of 50 + 2 of 12', 'eurojackpot' => 'Eurojackpot: 5 of 50 + 2 of 12', 'uk_lotto' => 'UK Lotto: 6 of 59', 'lotto_649' => 'Lotto 6/49 (Canada and others): 6 of 49', 'custom' => 'Other (enter the value)']" selected="custom" />
            <div data-show-when="format:custom">
                <x-calc.field name="k" label="Numbers picked" value="6" min="1" step="any" />
            </div>
            <div data-show-when="format:custom">
                <x-calc.field name="n" label="From a pool of" value="49" min="1" step="any" />
            </div>
            <div data-show-when="format:custom">
                <x-calc.field name="k2" label="Bonus numbers picked (0 if none)" value="0" min="0" step="any" />
            </div>
            <div data-show-when="format:custom">
                <x-calc.field name="n2" label="From a bonus pool of" value="10" min="1" step="any" />
            </div>
            <x-calc.field name="tickets" label="Tickets bought" value="1" min="1" step="any" />
            <x-calc.field name="price" label="Price per ticket" value="2" min="0" step="any" suffix="$" />
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Odds of the jackpot" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'format' => 'custom', 'k' => 6, 'n' => 49, 'k2' => 0, 'n2' => 10, 'tickets' => 1, 'price' => 2],
        'Practice' => ['format' => 'custom', 'k' => 6, 'n' => 49, 'k2' => 0, 'n2' => 10, 'tickets' => 1, 'price' => 2, 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'combos' => ['label' => 'Possible tickets'],
                'withTickets' => ['label' => 'Chance with your tickets'],
                'cost' => ['label' => 'Cost of the tickets'],
                'years' => ['label' => 'Draws needed for a 50% chance'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
        </div>
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Odds of each match" name="tiers" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
