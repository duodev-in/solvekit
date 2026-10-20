<x-calc.page
    title="Central Limit Theorem Calculator - SolveKit"
    description="Free central limit theorem calculator: the mean and standard error of the sample mean, and probabilities for it."
    lede="Apply the central limit theorem."
    about="The central limit theorem says sample means are approximately normal for large samples, centred on μ with standard error σ/√n."
    :calc="['engine' => 'st-dist', 'tool' => 'clt', 'fields' => ['mu', 'sigma', 'n', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(68 ≤ x̄ ≤ 73) in the example?', 'answer' => '0.774538 (SE 2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mu" label="Population mean μ" value="70" step="any" />
        <x-calc.field name="sigma" label="Population standard deviation σ" value="12" min="0" step="any" />
        <x-calc.field name="n" label="Sample size n" value="36" min="1" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(x̄ ≤ a)', 'ge' => 'P(x̄ ≥ a)', 'between' => 'P(a ≤ x̄ ≤ b)']" selected="between" />
        <x-calc.field name="a" label="a" value="68" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="b" value="73" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability for the sample mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mu' => 70, 'sigma' => 12, 'n' => 36, 'mode' => 'between', 'a' => 68, 'b' => 73],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Sampling distribution of the mean" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'se' => ['label' => 'Standard error σ/√n'],
            'za' => ['label' => 'z for a'],
            'zb' => ['label' => 'z for b'],
            'range' => ['label' => 'Middle 95% of sample means'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
