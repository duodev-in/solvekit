<x-calc.page
    title="Degrees of Freedom Calculator - SolveKit"
    description="Free degrees of freedom calculator: df for t-tests (including Welch), χ² tests, ANOVA and regression."
    lede="Find degrees of freedom."
    about="Degrees of freedom count the independent pieces of information available after estimating parameters."
    :calc="['engine' => 'st-inf', 'tool' => 'dof', 'fields' => ['test', 'n1', 'n2', 's1', 's2', 'k', 'r', 'c', 'N', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the Welch degrees of freedom in the example?', 'answer' => '23.681806.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="test" label="Test" :options="['one' => 'One-sample or paired t', 'pooled' => 'Two-sample t (equal variances)', 'welch' => 'Two-sample t (Welch)', 'gof' => 'χ² goodness of fit', 'indep' => 'χ² independence', 'anova' => 'One-way ANOVA', 'reg' => 'Linear regression']" selected="welch" />
        <div data-show-when="test:one,pooled,welch,reg">
            <x-calc.field name="n1" label="n (or n₁)" value="12" min="1" step="any" />
        </div>
        <div data-show-when="test:pooled,welch">
            <x-calc.field name="n2" label="n₂" value="15" min="1" step="any" />
        </div>
        <div data-show-when="test:welch">
            <x-calc.field name="s1" label="s₁" value="4.2" min="0" step="any" />
        </div>
        <div data-show-when="test:welch">
            <x-calc.field name="s2" label="s₂" value="6.8" min="0" step="any" />
        </div>
        <div data-show-when="test:gof,anova">
            <x-calc.field name="k" label="Categories or groups k" value="4" min="1" step="any" />
        </div>
        <div data-show-when="test:indep">
            <x-calc.field name="r" label="Rows" value="3" min="1" step="any" />
        </div>
        <div data-show-when="test:indep">
            <x-calc.field name="c" label="Columns" value="4" min="1" step="any" />
        </div>
        <div data-show-when="test:anova">
            <x-calc.field name="N" label="Total observations N" value="40" min="1" step="any" />
        </div>
        <div data-show-when="test:reg">
            <x-calc.field name="p" label="Predictors p" value="2" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Degrees of freedom" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['test' => 'welch', 'n1' => 12, 'n2' => 15, 's1' => 4.2, 's2' => 6.8, 'k' => 4, 'r' => 3, 'c' => 4, 'N' => 40, 'p' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
