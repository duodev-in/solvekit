<x-calc.page
    title="Power Analysis Calculator - SolveKit"
    description="Free power analysis calculator: statistical power or sample size for t-tests and two proportions."
    lede="Plan a sample size with power."
    about="Power is the chance a test detects a real effect. It depends on the effect size, sample size and α."
    :calc="['engine' => 'st-inf', 'tool' => 'power', 'fields' => ['test', 'solve', 'd', 'p1', 'p2', 'n', 'target', 'alpha', 'tail'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many per group detect d = 0.5 with 80% power?', 'answer' => '64 per group.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="test" label="Test" :options="['one' => 'One-sample or paired t-test', 'two' => 'Two-sample t-test (equal groups)', 'prop' => 'Two proportions (equal groups)']" selected="two" />
        <x-calc.select name="solve" label="Find" :options="['power' => 'Power for a sample size', 'n' => 'Sample size for a power']" selected="n" />
        <div data-show-when="test:one,two">
            <x-calc.field name="d" label="Effect size d (Cohen)" value="0.5" step="any" />
        </div>
        <div data-show-when="test:prop">
            <x-calc.field name="p1" label="Proportion 1" value="0.3" min="0" step="any" />
        </div>
        <div data-show-when="test:prop">
            <x-calc.field name="p2" label="Proportion 2" value="0.4" min="0" step="any" />
        </div>
        <div data-show-when="solve:power">
            <x-calc.field name="n" label="Sample size (per group)" value="30" min="2" step="any" />
        </div>
        <div data-show-when="solve:n">
            <x-calc.field name="target" label="Target power" value="0.8" min="0" step="any" />
        </div>
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
        <x-calc.select name="tail" label="Test" :options="['two' => 'Two-sided', 'right' => 'One-sided']" selected="two" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['test' => 'two', 'solve' => 'n', 'd' => 0.5, 'p1' => 0.3, 'p2' => 0.4, 'n' => 30, 'target' => 0.8, 'alpha' => 0.05, 'tail' => 'two'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Power by sample size" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'effect' => ['label' => 'Effect size'],
            'other' => ['label' => 'Detail'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
