<x-calc.page
    title="Odds Ratio Calculator - SolveKit"
    description="Free odds ratio calculator: OR with confidence interval and p-value from a 2 × 2 table (Woolf), with a zero-cell correction."
    lede="Find an odds ratio."
    about="The odds ratio compares the odds of an outcome in two groups: (a × d) ÷ (b × c). It is the usual measure in case–control studies."
    :calc="['engine' => 'st-prob', 'tool' => 'odds_ratio', 'fields' => ['a', 'b', 'c', 'd', 'conf'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the odds ratio in the example?', 'answer' => '2.6667 (CI 1.4166 to 5.0199).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Exposed: with the outcome (cases)" value="40" min="0" step="any" />
        <x-calc.field name="b" label="Exposed: without (controls)" value="60" min="0" step="any" />
        <x-calc.field name="c" label="Unexposed: with the outcome" value="20" min="0" step="any" />
        <x-calc.field name="d" label="Unexposed: without" value="80" min="0" step="any" />
        <x-calc.field name="conf" label="Confidence (%)" value="95" min="0" step="any" />
    </div>

    <x-calc.result label="Odds ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 40, 'b' => 60, 'c' => 20, 'd' => 80, 'conf' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ci' => ['label' => 'Confidence interval'],
            'p' => ['label' => 'p-value (z test on ln OR)'],
            'logor' => ['label' => 'ln(OR) ± SE'],
            'note' => ['label' => 'Zero cells'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
