<x-calc.page
    title="t-test Calculator - SolveKit"
    description="Free t-test calculator: Welch, pooled, paired and one-sample t-tests from data or summaries, with p-value, CI and effect size."
    lede="Run a t-test."
    about="A t-test compares means: one mean with a value, two independent means, or paired measurements."
    :calc="['engine' => 'st-inf', 'tool' => 't_test', 'fields' => ['type', 'input', 'a', 'b', 'm1', 's1', 'n1', 'm2', 's2', 'n2', 'mu', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does Welch’s test give for the example?', 'answer' => 't = −4.95369, p = 0.0001968.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Test" :options="['welch' => 'Two independent samples (Welch, unequal variances)', 'pooled' => 'Two independent samples (pooled, equal variances)', 'paired' => 'Paired samples', 'one' => 'One sample']" selected="welch" />
        <x-calc.select name="input" label="Enter" :options="['data' => 'Raw data', 'summary' => 'Means, SDs and sizes']" selected="data" />
        <div data-show-when="input:data">
            <x-calc.textarea name="a" label="Sample 1 (or the only sample / before)" value="12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3" rows="3" />
        </div>
        <div data-show-when="input:data">
            <x-calc.textarea name="b" label="Sample 2 (or after)" value="15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9" rows="3" />
        </div>
        <div data-show-when="input:summary">
            <x-calc.field name="m1" label="Mean 1" value="13.5" step="any" />
        </div>
        <div data-show-when="input:summary">
            <x-calc.field name="s1" label="SD 1" value="1.2" min="0" step="any" />
        </div>
        <div data-show-when="input:summary">
            <x-calc.field name="n1" label="Size 1" value="8" min="2" step="any" />
        </div>
        <div data-show-when="input:summary">
            <x-calc.field name="m2" label="Mean 2" value="16.3" step="any" />
        </div>
        <div data-show-when="input:summary">
            <x-calc.field name="s2" label="SD 2" value="1.1" min="0" step="any" />
        </div>
        <div data-show-when="input:summary">
            <x-calc.field name="n2" label="Size 2" value="9" min="2" step="any" />
        </div>
        <x-calc.field name="mu" label="Hypothesised mean or difference" value="0" step="any" />
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="t" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'welch', 'input' => 'data', 'a' => '12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3', 'b' => '15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9', 'm1' => 13.5, 's1' => 1.2, 'n1' => 8, 'm2' => 16.3, 's2' => 1.1, 'n2' => 9, 'mu' => 0, 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="t distribution (shaded: p-value)" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'df' => ['label' => 'Degrees of freedom'],
            'p' => ['label' => 'p-value'],
            'ci' => ['label' => 'Confidence interval for the difference'],
            'd' => ['label' => 'Cohen’s d'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
