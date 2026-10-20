<x-calc.page
    title="McNemar's Test Calculator - SolveKit"
    description="Free McNemar's test calculator: paired yes/no data with χ², continuity correction and exact p-value."
    lede="Run McNemar's test."
    about="McNemar's test checks whether a paired proportion changed, using only the pairs that switched."
    :calc="['engine' => 'st-inf', 'tool' => 'mcnemar', 'fields' => ['a', 'b', 'c', 'd', 'correct', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the p-value for the example?', 'answer' => '0.04852.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Both yes (before yes, after yes)" value="30" min="0" step="any" />
        <x-calc.field name="b" label="Yes before, no after" value="12" min="0" step="any" />
        <x-calc.field name="c" label="No before, yes after" value="25" min="0" step="any" />
        <x-calc.field name="d" label="Both no" value="33" min="0" step="any" />
        <x-calc.select name="correct" label="Continuity correction" :options="['yes' => 'Yes (Edwards)', 'no' => 'No']" selected="yes" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="p-value (χ²)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 30, 'b' => 12, 'c' => 25, 'd' => 33, 'correct' => 'yes', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'chi' => ['label' => 'χ² (1 df)'],
            'exact' => ['label' => 'Exact p-value (binomial)'],
            'change' => ['label' => 'Discordant pairs b and c'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
