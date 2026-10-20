<x-calc.page
    title="Likelihood Ratio Calculator - SolveKit"
    description="Free likelihood ratio calculator: LR+ and LR− from sensitivity and specificity, and the probability after a positive or negative test."
    lede="Find likelihood ratios."
    about="A likelihood ratio says how much a test result changes the odds of a condition. LR+ above 10 or LR− below 0.1 changes them a lot."
    :calc="['engine' => 'st-prob', 'tool' => 'likelihood_ratio', 'fields' => ['sens', 'spec', 'pre'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are LR+ and LR− for 85% sensitivity and 90% specificity?', 'answer' => '8.5 and 0.16667.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sens" label="Sensitivity (%)" value="85" min="0" step="any" />
        <x-calc.field name="spec" label="Specificity (%)" value="90" min="0" step="any" />
        <x-calc.field name="pre" label="Pre-test probability (%, optional)" value="20" min="0" step="any" />
    </div>

    <x-calc.result label="Positive likelihood ratio (LR+)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sens' => 85, 'spec' => 90, 'pre' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lrn' => ['label' => 'Negative likelihood ratio (LR−)'],
            'postPos' => ['label' => 'Probability after a positive'],
            'postNeg' => ['label' => 'Probability after a negative'],
            'strength' => ['label' => 'How useful'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
