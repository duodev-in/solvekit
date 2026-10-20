<x-calc.page
    title="Coin Flip Probability Calculator - SolveKit"
    description="Free coin flip probability calculator: the chance of exactly, at least or at most k heads in n flips (binomial)."
    lede="Find coin flip probabilities."
    about="The number of heads in n flips follows the binomial distribution. This works for fair and biased coins."
    :calc="['engine' => 'st-prob', 'tool' => 'coin_prob', 'fields' => ['n', 'mode', 'k', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance of exactly 5 heads in 10 flips?', 'answer' => '0.246094.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Number of flips" value="10" min="1" step="any" />
        <x-calc.select name="mode" label="Heads wanted" :options="['eq' => 'Exactly', 'le' => 'At most', 'ge' => 'At least', 'lt' => 'Fewer than', 'gt' => 'More than']" selected="eq" />
        <x-calc.field name="k" label="Number of heads" value="5" min="0" step="any" />
        <x-calc.field name="p" label="P(heads) on one flip" value="0.5" min="0" step="any" />
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 10, 'mode' => 'eq', 'k' => 5, 'p' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Number of heads" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'P(exactly k)'],
            'atleast' => ['label' => 'P(at least k)'],
            'atmost' => ['label' => 'P(at most k)'],
            'mean' => ['label' => 'Expected heads'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
