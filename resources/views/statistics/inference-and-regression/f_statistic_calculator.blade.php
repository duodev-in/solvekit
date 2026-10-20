<x-calc.page
    title="F-statistic Calculator - SolveKit"
    description="Free F-statistic calculator: F test for equal variances from SDs or raw data, with p-value and critical values."
    lede="Compare two variances."
    about="The F statistic is the ratio of two sample variances. Under equal population variances it follows an F distribution."
    :calc="['engine' => 'st-inf', 'tool' => 'f_stat', 'fields' => ['mode', 's1', 'n1', 's2', 'n2', 'a', 'b', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is F in the example?', 'answer' => '2.28673 (p = 0.05485).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['summary' => 'Two standard deviations', 'data' => 'Two samples']" selected="summary" />
        <div data-show-when="mode:summary">
            <x-calc.field name="s1" label="SD of sample 1" value="6.2" min="0" step="any" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="n1" label="Size of sample 1" value="21" min="2" step="any" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="s2" label="SD of sample 2" value="4.1" min="0" step="any" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="n2" label="Size of sample 2" value="25" min="2" step="any" />
        </div>
        <div data-show-when="mode:data">
            <x-calc.textarea name="a" label="Sample 1" value="12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3" rows="3" />
        </div>
        <div data-show-when="mode:data">
            <x-calc.textarea name="b" label="Sample 2" value="15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9" rows="3" />
        </div>
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="F statistic" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'summary', 's1' => 6.2, 'n1' => 21, 's2' => 4.1, 'n2' => 25, 'a' => '12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3', 'b' => '15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9', 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="F distribution" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'df' => ['label' => 'Degrees of freedom'],
            'p' => ['label' => 'p-value'],
            'crit' => ['label' => 'Critical value(s)'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
