<x-calc.page
    title="Wilcoxon Signed-Rank Test Calculator - SolveKit"
    description="Free Wilcoxon signed-rank test calculator: paired or one-sample test with exact or normal p-value."
    lede="Run a Wilcoxon signed-rank test."
    about="The Wilcoxon signed-rank test checks whether paired differences are centred on zero, using ranks instead of assuming normality."
    :calc="['engine' => 'st-inf', 'tool' => 'wilcoxon_signed', 'fields' => ['mode', 'a', 'b', 'm0', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the p-value for the example?', 'answer' => '0.01052.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Data" :options="['paired' => 'Paired samples (before and after)', 'one' => 'One sample against a median']" selected="paired" />
        <x-calc.textarea name="a" label="Sample 1 (before) or the sample" value="125, 132, 118, 140, 128, 135, 122, 130, 138, 126" rows="3" />
        <div data-show-when="mode:paired">
            <x-calc.textarea name="b" label="Sample 2 (after)" value="120, 128, 119, 131, 122, 127, 121, 124, 130, 125" rows="3" />
        </div>
        <div data-show-when="mode:one">
            <x-calc.field name="m0" label="Hypothesised median" value="0" step="any" />
        </div>
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="V (sum of positive ranks)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'paired', 'a' => '125, 132, 118, 140, 128, 135, 122, 130, 138, 126', 'b' => '120, 128, 119, 131, 122, 127, 121, 124, 130, 125', 'm0' => 0, 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value'],
            'w' => ['label' => 'W = min(V⁺, V⁻)'],
            'n' => ['label' => 'Non-zero differences used'],
            'method' => ['label' => 'Method'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
