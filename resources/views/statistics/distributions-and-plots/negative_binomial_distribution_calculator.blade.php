<x-calc.page
    title="Negative Binomial Distribution Calculator - SolveKit"
    description="Free negative binomial calculator: the probability of k failures before the r-th success, cumulative probabilities and the mean."
    lede="Find negative binomial probabilities."
    about="The negative binomial distribution counts failures (or trials) until a set number of successes."
    :calc="['engine' => 'st-dist', 'tool' => 'neg_binomial', 'fields' => ['r', 'p', 'form', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X = 4) for r = 3, p = 0.4?', 'answer' => '0.124416.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r" label="Successes needed r" value="3" min="1" step="any" />
        <x-calc.field name="p" label="Success probability p" value="0.4" min="0" step="any" />
        <x-calc.select name="form" label="Count" :options="['failures' => 'Failures before the r-th success (0, 1, …)', 'trials' => 'Trials to the r-th success (r, r + 1, …)']" selected="failures" />
        <x-calc.select name="mode" label="Find" :options="['eq' => 'P(X = k)', 'le' => 'P(X ≤ k)', 'lt' => 'P(X < k)', 'ge' => 'P(X ≥ k)', 'gt' => 'P(X > k)', 'between' => 'P(a ≤ X ≤ b)']" selected="eq" />
        <x-calc.field name="a" label="k (or the lower limit a)" value="4" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="Upper limit b" value="6" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['r' => 3, 'p' => 0.4, 'form' => 'failures', 'mode' => 'eq', 'a' => 4, 'b' => 6],
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
