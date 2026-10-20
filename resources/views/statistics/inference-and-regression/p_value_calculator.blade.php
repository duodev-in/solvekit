<x-calc.page
    title="p-value Calculator - SolveKit"
    description="Free p-value calculator: p-values from z, t, χ² or F statistics, one- or two-tailed."
    lede="Find a p-value."
    about="A p-value is the probability of a result at least as extreme as yours if the null hypothesis were true."
    :calc="['engine' => 'st-inf', 'tool' => 'p_value', 'fields' => ['dist', 'stat', 'tail', 'df1', 'df2', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the two-tailed p for z = 1.96?', 'answer' => '0.05.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dist" label="Statistic" :options="['z' => 'z', 't' => 't', 'chi2' => 'χ²', 'f' => 'F']" selected="z" />
        <x-calc.field name="stat" label="Value of the statistic" value="1.96" step="any" />
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <div data-show-when="dist:t,chi2,f">
            <x-calc.field name="df1" label="Degrees of freedom (df₁)" value="10" min="0" step="any" />
        </div>
        <div data-show-when="dist:f">
            <x-calc.field name="df2" label="Denominator df (df₂, F only)" value="20" min="0" step="any" />
        </div>
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="p-value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dist' => 'z', 'stat' => 1.96, 'tail' => 'two', 'df1' => 10, 'df2' => 20, 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Shaded area = p-value" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'verdict' => ['label' => 'Decision'],
            'levels' => ['label' => 'Significant at'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
