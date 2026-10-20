<x-calc.page
    title="Z-test Calculator - SolveKit"
    description="Free z-test calculator: one or two means with known σ, one or two proportions, with p-value and CI."
    lede="Run a z-test."
    about="A z-test compares a sample statistic with a hypothesised value when the standard error is known or the sample is large."
    :calc="['engine' => 'st-inf', 'tool' => 'z_test', 'fields' => ['type', 'm1', 's1', 'n1', 'm2', 's2', 'n2', 'x1', 'x2', 'h0', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is z in the example?', 'answer' => '1.88562 (p = 0.05935).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Test" :options="['mean' => 'One mean (σ known)', 'mean2' => 'Two means (σ known)', 'prop' => 'One proportion', 'prop2' => 'Two proportions']" selected="mean" />
        <div data-show-when="type:mean,mean2">
            <x-calc.field name="m1" label="Sample mean 1" value="104" step="any" />
        </div>
        <div data-show-when="type:mean,mean2">
            <x-calc.field name="s1" label="Population SD σ₁" value="15" min="0" step="any" />
        </div>
        <x-calc.field name="n1" label="Sample size 1" value="50" min="1" step="any" />
        <div data-show-when="type:mean2">
            <x-calc.field name="m2" label="Sample mean 2" value="98" step="any" />
        </div>
        <div data-show-when="type:mean2">
            <x-calc.field name="s2" label="Population SD σ₂" value="15" min="0" step="any" />
        </div>
        <div data-show-when="type:mean2,prop2">
            <x-calc.field name="n2" label="Sample size 2" value="50" min="1" step="any" />
        </div>
        <div data-show-when="type:prop,prop2">
            <x-calc.field name="x1" label="Successes 1" value="62" min="0" step="any" />
        </div>
        <div data-show-when="type:prop2">
            <x-calc.field name="x2" label="Successes 2" value="48" min="0" step="any" />
        </div>
        <x-calc.field name="h0" label="Value under H₀ (μ₀, p₀ or difference)" value="100" step="any" />
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="z" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'mean', 'm1' => 104, 's1' => 15, 'n1' => 50, 'm2' => 98, 's2' => 15, 'n2' => 50, 'x1' => 62, 'x2' => 48, 'h0' => 100, 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Standard normal (shaded: p-value)" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value'],
            'crit' => ['label' => 'Critical value'],
            'ci' => ['label' => 'Confidence interval'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
