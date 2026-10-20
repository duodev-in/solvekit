<x-calc.page
    title="Critical Value Calculator - SolveKit"
    description="Free critical value calculator: z, t, χ² and F critical values for any α and tail."
    lede="Find a critical value."
    about="A critical value marks the edge of the rejection region of a test at significance level α."
    :calc="['engine' => 'st-inf', 'tool' => 'critical_value', 'fields' => ['dist', 'alpha', 'tail', 'df1', 'df2'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the two-tailed z critical value at α = 0.05?', 'answer' => '±1.95996.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dist" label="Distribution" :options="['z' => 'Standard normal (z)', 't' => 'Student t', 'chi2' => 'Chi-square (χ²)', 'f' => 'F']" selected="z" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <div data-show-when="dist:t,chi2,f">
            <x-calc.field name="df1" label="Degrees of freedom (df₁)" value="10" min="0" step="any" />
        </div>
        <div data-show-when="dist:f">
            <x-calc.field name="df2" label="Denominator df (df₂, F only)" value="20" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Critical value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dist' => 'z', 'alpha' => 0.05, 'tail' => 'two', 'df1' => 10, 'df2' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Rejection region" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'region' => ['label' => 'Rejection region'],
            'confidence' => ['label' => 'Matching confidence level'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
