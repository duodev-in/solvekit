<x-calc.page
    title="t-statistic Calculator - SolveKit"
    description="Free t-statistic calculator: one-sample t with degrees of freedom and p-value."
    lede="Find the t statistic."
    about="The t statistic measures how many standard errors the sample mean is from the hypothesised mean."
    :calc="['engine' => 'st-inf', 'tool' => 't_stat', 'fields' => ['mean', 'mu', 's', 'n', 'tail'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is t in the example?', 'answer' => '1.8852459.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mean" label="Sample mean x̄" value="52.3" step="any" />
        <x-calc.field name="mu" label="Hypothesised mean μ₀" value="50" step="any" />
        <x-calc.field name="s" label="Sample standard deviation s" value="6.1" min="0" step="any" />
        <x-calc.field name="n" label="Sample size n" value="25" min="2" step="any" />
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
    </div>

    <x-calc.result label="t" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mean' => 52.3, 'mu' => 50, 's' => 6.1, 'n' => 25, 'tail' => 'two'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'df' => ['label' => 'Degrees of freedom'],
            'se' => ['label' => 'Standard error s/√n'],
            'p' => ['label' => 'p-value'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
