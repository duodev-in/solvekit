<x-calc.page
    title="Relative Risk Calculator - SolveKit"
    description="Free relative risk calculator: risk ratio with confidence interval, risk difference, odds ratio and NNT from a 2 × 2 table."
    lede="Find the relative risk."
    about="Relative risk compares the risk of an outcome in an exposed group with an unexposed group: RR = risk exposed ÷ risk unexposed."
    :calc="['engine' => 'st-prob', 'tool' => 'relative_risk', 'fields' => ['a', 'b', 'c', 'd', 'conf'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the relative risk in the example?', 'answer' => '2 (CI 1.1489 to 3.4817).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Exposed: with the outcome" value="30" min="0" step="any" />
        <x-calc.field name="b" label="Exposed: without" value="70" min="0" step="any" />
        <x-calc.field name="c" label="Unexposed: with the outcome" value="15" min="0" step="any" />
        <x-calc.field name="d" label="Unexposed: without" value="85" min="0" step="any" />
        <x-calc.field name="conf" label="Confidence (%)" value="95" min="0" step="any" />
    </div>

    <x-calc.result label="Relative risk" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 30, 'b' => 70, 'c' => 15, 'd' => 85, 'conf' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ci' => ['label' => 'Confidence interval'],
            'riskE' => ['label' => 'Risk if exposed'],
            'riskU' => ['label' => 'Risk if unexposed'],
            'rd' => ['label' => 'Risk difference'],
            'or' => ['label' => 'Odds ratio'],
            'nnt' => ['label' => 'Number needed to treat / harm'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
