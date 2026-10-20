<x-calc.page
    title="Hypothesis Testing Calculator - SolveKit"
    description="Free hypothesis testing calculator: one-sample t, z or proportion tests with the five-step working and a decision."
    lede="Test a hypothesis."
    about="A hypothesis test asks whether the data are surprising if the null hypothesis were true, measured by the p-value."
    :calc="['engine' => 'st-inf', 'tool' => 'hypothesis', 'fields' => ['test', 'h0', 'mean', 'sd', 'n', 'x', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the decision in the example?', 'answer' => 'Reject H₀ (p = 0.04301 < α = 0.05).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="test" label="Test" :options="['t' => 'Mean, σ unknown (t-test)', 'z' => 'Mean, σ known (z-test)', 'prop' => 'Proportion (z-test)']" selected="t" />
        <x-calc.field name="h0" label="Value under H₀ (μ₀ or p₀)" value="100" step="any" />
        <div data-show-when="test:t,z">
            <x-calc.field name="mean" label="Sample mean" value="104.2" step="any" />
        </div>
        <div data-show-when="test:t,z">
            <x-calc.field name="sd" label="Standard deviation (s or σ)" value="12" min="0" step="any" />
        </div>
        <x-calc.field name="n" label="Sample size" value="36" min="1" step="any" />
        <div data-show-when="test:prop">
            <x-calc.field name="x" label="Successes" value="58" min="0" step="any" />
        </div>
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="Decision" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['test' => 't', 'h0' => 100, 'mean' => 104.2, 'sd' => 12, 'n' => 36, 'x' => 58, 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="p-value region" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'stat' => ['label' => 'Test statistic'],
            'p' => ['label' => 'p-value'],
            'crit' => ['label' => 'Critical value'],
            'h' => ['label' => 'Hypotheses'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
