<x-calc.page
    title="Fisher's Exact Test Calculator - SolveKit"
    description="Free Fisher's exact test calculator: exact p-value for a 2 × 2 table, one- or two-sided."
    lede="Run Fisher's exact test."
    about="Fisher's exact test checks whether two categorical variables are associated, exactly, even for small counts."
    :calc="['engine' => 'st-inf', 'tool' => 'fisher', 'fields' => ['a', 'b', 'c', 'd', 'alt', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the p-value for the example table?', 'answer' => '0.0213.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Row 1, column 1" value="3" min="0" step="any" />
        <x-calc.field name="b" label="Row 1, column 2" value="9" min="0" step="any" />
        <x-calc.field name="c" label="Row 2, column 1" value="11" min="0" step="any" />
        <x-calc.field name="d" label="Row 2, column 2" value="4" min="0" step="any" />
        <x-calc.select name="alt" label="Alternative" :options="['two' => 'Two-sided', 'less' => 'Odds ratio < 1', 'greater' => 'Odds ratio > 1']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="p-value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 3, 'b' => 9, 'c' => 11, 'd' => 4, 'alt' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'or' => ['label' => 'Sample odds ratio'],
            'pobs' => ['label' => 'P(this exact table)'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
