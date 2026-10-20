<x-calc.page
    title="ANOVA Calculator - SolveKit"
    description="Free one-way ANOVA calculator: F, p-value and the full ANOVA table for three or more groups."
    lede="Run a one-way ANOVA."
    about="Analysis of variance tests whether several group means are equal by comparing the variation between groups with the variation within them."
    :calc="['engine' => 'st-inf', 'tool' => 'anova', 'fields' => ['data', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does ANOVA give for the example diets?', 'answer' => 'F = 12.9363, p = 0.001012.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Groups: one per line, optionally named (“Diet A: 4.2, 5.1, …”)" value="Diet A: 4.2, 5.1, 3.8, 4.9, 5.4
Diet B: 6.1, 5.8, 6.9, 7.2, 6.4
Diet C: 5.0, 4.6, 5.9, 5.3, 4.8" rows="3" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="F statistic" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => 'Diet A: 4.2, 5.1, 3.8, 4.9, 5.4
Diet B: 6.1, 5.8, 6.9, 7.2, 6.4
Diet C: 5.0, 4.6, 5.9, 5.3, 4.8', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value'],
            'eta' => ['label' => 'η² (effect size)'],
            'crit' => ['label' => 'Critical F'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="ANOVA table" name="table" :scroll="true" />
        <x-calc.grid heading="Group summaries" name="groups" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
