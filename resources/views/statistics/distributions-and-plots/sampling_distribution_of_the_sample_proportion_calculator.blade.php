<x-calc.page
    title="Sampling Distribution of the Sample Proportion Calculator - SolveKit"
    description="Free sampling distribution of p̂ calculator: probabilities for the sample proportion with the normal model and its conditions."
    lede="Find probabilities for a sample proportion."
    about="For large samples p̂ is approximately normal with mean p and standard error √(p(1 − p)/n)."
    :calc="['engine' => 'st-dist', 'tool' => 'sampling_prop', 'fields' => ['p', 'n', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(p̂ ≥ 0.45) for p = 0.4, n = 100?', 'answer' => '0.153717.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Population proportion p" value="0.4" min="0" step="any" />
        <x-calc.field name="n" label="Sample size n" value="100" min="1" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(p̂ ≤ a)', 'ge' => 'P(p̂ ≥ a)', 'between' => 'P(a ≤ p̂ ≤ b)']" selected="ge" />
        <x-calc.field name="a" label="a" value="0.45" min="0" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="b" value="0.5" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => 0.4, 'n' => 100, 'mode' => 'ge', 'a' => 0.45, 'b' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Sampling distribution of p̂" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'se' => ['label' => 'Standard error √(p(1 − p)/n)'],
            'z' => ['label' => 'z for a'],
            'check' => ['label' => 'np and n(1 − p)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
