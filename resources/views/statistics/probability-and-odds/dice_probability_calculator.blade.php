<x-calc.page
    title="Dice Probability Calculator - SolveKit"
    description="Free dice probability calculator: the exact chance of rolling a total with any number of dice, plus the full table of totals."
    lede="Find dice probabilities."
    about="The total of several dice is found by convolving the single-die distributions, giving exact probabilities for every total. Also known as 6 Sided Dice Probability Calculator and Two Dice Probability Calculator."
    :calc="['engine' => 'st-prob', 'tool' => 'dice_prob', 'fields' => ['n', 'sides', 'mode', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance of rolling 7 with two dice?', 'answer' => '0.166667 (6 of 36 (1/6)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Number of dice" value="2" min="1" step="any" />
        <x-calc.field name="sides" label="Sides on each die" value="6" min="2" step="any" />
        <x-calc.select name="mode" label="Total wanted" :options="['eq' => 'Exactly', 'le' => 'At most', 'ge' => 'At least', 'lt' => 'Fewer than', 'gt' => 'More than']" selected="eq" />
        <x-calc.field name="target" label="Target total" value="7" step="any" />
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 2, 'sides' => 6, 'mode' => 'eq', 'target' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Distribution of the total" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'odds' => ['label' => 'Odds'],
            'ways' => ['label' => 'Ways out of all outcomes'],
            'mean' => ['label' => 'Average total'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Every total" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
