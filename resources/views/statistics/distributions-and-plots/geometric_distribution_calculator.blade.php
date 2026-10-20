<x-calc.page
    title="Geometric Distribution Calculator - SolveKit"
    description="Free geometric distribution calculator: the probability that the first success comes on trial k, cumulative probabilities and the mean."
    lede="Find geometric probabilities."
    about="The geometric distribution counts trials until the first success, each with success probability p."
    :calc="['engine' => 'st-dist', 'tool' => 'geometric', 'fields' => ['p', 'form', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X = 3) for p = 0.2?', 'answer' => '0.128.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Success probability p" value="0.2" min="0" step="any" />
        <x-calc.select name="form" label="Count" :options="['trials' => 'Trials up to and including the first success (1, 2, …)', 'failures' => 'Failures before the first success (0, 1, …)']" selected="trials" />
        <x-calc.select name="mode" label="Find" :options="['eq' => 'P(X = k)', 'le' => 'P(X ≤ k)', 'lt' => 'P(X < k)', 'ge' => 'P(X ≥ k)', 'gt' => 'P(X > k)', 'between' => 'P(a ≤ X ≤ b)']" selected="eq" />
        <x-calc.field name="a" label="k (or the lower limit a)" value="3" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="Upper limit b" value="5" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => 0.2, 'form' => 'trials', 'mode' => 'eq', 'a' => 3, 'b' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Probabilities with the region highlighted" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'eq' => ['label' => 'P(X = k)'],
            'le' => ['label' => 'P(X ≤ k)'],
            'ge' => ['label' => 'P(X ≥ k)'],
            'mean' => ['label' => 'Mean'],
            'sd' => ['label' => 'Standard deviation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
