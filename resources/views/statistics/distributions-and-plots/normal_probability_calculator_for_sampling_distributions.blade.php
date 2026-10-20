<x-calc.page
    title="Normal Probability Calculator for Sampling Distributions - SolveKit"
    description="Free calculator for the sampling distribution of the mean: probabilities for x̄ with optional finite population correction."
    lede="Find probabilities for a sample mean."
    about="The sample mean varies from sample to sample around μ with standard error σ/√n. This page finds probabilities for it."
    :calc="['engine' => 'st-dist', 'tool' => 'sampling_mean', 'fields' => ['mu', 'sigma', 'n', 'N', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(x̄ ≥ 530) in the example?', 'answer' => '0.0668072.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mu" label="Population mean μ" value="500" step="any" />
        <x-calc.field name="sigma" label="Population SD σ" value="100" min="0" step="any" />
        <x-calc.field name="n" label="Sample size n" value="25" min="1" step="any" />
        <x-calc.field name="N" label="Population size (0 = very large)" value="0" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(x̄ ≤ a)', 'ge' => 'P(x̄ ≥ a)', 'between' => 'P(a ≤ x̄ ≤ b)']" selected="ge" />
        <x-calc.field name="a" label="a" value="530" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="b" value="540" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mu' => 500, 'sigma' => 100, 'n' => 25, 'N' => 0, 'mode' => 'ge', 'a' => 530, 'b' => 540],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Sampling distribution of x̄" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'se' => ['label' => 'Standard error of x̄'],
            'z' => ['label' => 'z'],
            'fpc' => ['label' => 'Finite population correction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
