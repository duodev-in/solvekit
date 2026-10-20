<x-calc.page
    title="Sign Test Calculator - SolveKit"
    description="Free sign test calculator: exact binomial test on the signs of paired differences or against a median."
    lede="Run a sign test."
    about="The sign test counts how many differences are positive and negative and asks whether that split could be chance."
    :calc="['engine' => 'st-inf', 'tool' => 'sign_test', 'fields' => ['mode', 'a', 'b', 'm0', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the p-value for the example?', 'answer' => '0.03906.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Data" :options="['paired' => 'Paired samples', 'one' => 'One sample against a median']" selected="paired" />
        <x-calc.textarea name="a" label="Sample 1 (before) or the sample" value="7, 5, 8, 6, 9, 4, 7, 8, 6, 9, 7" rows="3" />
        <div data-show-when="mode:paired">
            <x-calc.textarea name="b" label="Sample 2 (after)" value="6, 5, 6, 4, 7, 5, 5, 6, 6, 7, 5" rows="3" />
        </div>
        <div data-show-when="mode:one">
            <x-calc.field name="m0" label="Hypothesised median" value="0" step="any" />
        </div>
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="p-value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'paired', 'a' => '7, 5, 8, 6, 9, 4, 7, 8, 6, 9, 7', 'b' => '6, 5, 6, 4, 7, 5, 5, 6, 6, 7, 5', 'm0' => 0, 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'signs' => ['label' => 'Plus / minus signs'],
            'zeros' => ['label' => 'Ties (dropped)'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
