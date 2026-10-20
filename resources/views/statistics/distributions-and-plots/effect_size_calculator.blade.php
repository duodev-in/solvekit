<x-calc.page
    title="Effect Size Calculator - SolveKit"
    description="Free effect size calculator: Cohen’s d and Hedges’ g from group statistics, or converted from t, r or an odds ratio."
    lede="Find an effect size."
    about="An effect size measures how large a difference or relationship is, independent of sample size. Cohen’s d expresses it in standard deviations."
    :calc="['engine' => 'st-dist', 'tool' => 'effect_size', 'fields' => ['mode', 'm1', 's1', 'n1', 'm2', 's2', 'n2', 't', 'r', 'or'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is Cohen’s d in the example?', 'answer' => '0.48247.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['groups' => 'Two group means and SDs', 't' => 'A t statistic', 'r' => 'A correlation r', 'or' => 'An odds ratio']" selected="groups" />
        <div data-show-when="mode:groups">
            <x-calc.field name="m1" label="Mean 1" value="105" step="any" />
        </div>
        <div data-show-when="mode:groups">
            <x-calc.field name="s1" label="SD 1" value="15" min="0" step="any" />
        </div>
        <div data-show-when="mode:groups,t">
            <x-calc.field name="n1" label="Size 1" value="30" min="2" step="any" />
        </div>
        <div data-show-when="mode:groups">
            <x-calc.field name="m2" label="Mean 2" value="98" step="any" />
        </div>
        <div data-show-when="mode:groups">
            <x-calc.field name="s2" label="SD 2" value="14" min="0" step="any" />
        </div>
        <div data-show-when="mode:groups,t">
            <x-calc.field name="n2" label="Size 2" value="30" min="2" step="any" />
        </div>
        <div data-show-when="mode:t">
            <x-calc.field name="t" label="t" value="2.5" step="any" />
        </div>
        <div data-show-when="mode:r">
            <x-calc.field name="r" label="r" value="0.3" step="any" />
        </div>
        <div data-show-when="mode:or">
            <x-calc.field name="or" label="Odds ratio" value="2.5" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Cohen’s d" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'groups', 'm1' => 105, 's1' => 15, 'n1' => 30, 'm2' => 98, 's2' => 14, 'n2' => 30, 't' => 2.5, 'r' => 0.3, 'or' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g' => ['label' => 'Hedges’ g (small-sample corrected)'],
            'r' => ['label' => 'Correlation r'],
            'eta' => ['label' => 'η² (variance explained)'],
            'size' => ['label' => 'Size (Cohen 1988)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
