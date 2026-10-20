<x-calc.page
    title="Point Estimate Calculator - SolveKit"
    description="Free point estimate calculator: MLE, Laplace, Jeffreys and Wilson estimates of a proportion and which to use."
    lede="Estimate a proportion."
    about="With small samples, x/n can be misleading. Adjusted estimators pull the estimate towards 50% by different amounts."
    :calc="['engine' => 'st-inf', 'tool' => 'point_estimate', 'fields' => ['x', 'n', 'conf'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the best estimate for 9 of 10?', 'answer' => '0.833333.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Successes x" value="9" min="0" step="any" />
        <x-calc.field name="n" label="Trials n" value="10" min="1" step="any" />
        <x-calc.field name="conf" label="Confidence level (%)" value="95" min="0" step="any" />
    </div>

    <x-calc.result label="Best point estimate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 9, 'n' => 10, 'conf' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mle' => ['label' => 'Maximum likelihood x/n'],
            'laplace' => ['label' => 'Laplace (x + 1)/(n + 2)'],
            'jeffreys' => ['label' => 'Jeffreys (x + ½)/(n + 1)'],
            'wilson' => ['label' => 'Wilson (x + z²/2)/(n + z²)'],
            'rule' => ['label' => 'Which one'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
