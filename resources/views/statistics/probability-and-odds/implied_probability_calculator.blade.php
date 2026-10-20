<x-calc.page
    title="Implied Probability Calculator - SolveKit"
    description="Free implied probability calculator: convert decimal, fractional or moneyline odds into probabilities and find the bookmaker margin."
    lede="Find implied probability from odds."
    about="Implied probability is 1 ÷ decimal odds. Across a whole market the implied probabilities add up to more than 100%; the excess is the bookmaker’s margin."
    :calc="['engine' => 'st-prob', 'tool' => 'implied', 'fields' => ['odds'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the total implied probability of the example market?', 'answer' => '103.7%.'],
    ]"
>
    <x-calc.textarea name="odds" label="Odds for each outcome (decimal 2.5, fractional 6/4, moneyline +150 or −200; one per line)" value="2.10
3.40
3.75" rows="3" />

    <x-calc.result label="Total implied probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['odds' => '2.10
3.40
3.75'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'margin' => ['label' => 'Bookmaker margin (overround)'],
            'first' => ['label' => 'First outcome'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Each outcome" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
