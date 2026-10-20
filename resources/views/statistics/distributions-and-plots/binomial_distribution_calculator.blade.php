<x-calc.page
    title="Binomial Distribution Calculator - SolveKit"
    description="Free binomial distribution calculator: exact P(X = k), P(X ≤ k), P(X ≥ k) and ranges for n trials, with a chart."
    lede="Find binomial probabilities."
    about="The binomial distribution counts successes in n independent trials with the same success probability p."
    :calc="['engine' => 'st-dist', 'tool' => 'binomial', 'fields' => ['n', 'p', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X = 6) for n = 20, p = 0.3?', 'answer' => '0.19163898.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Trials n" value="20" min="0" step="any" />
        <x-calc.field name="p" label="Success probability p" value="0.3" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['eq' => 'P(X = k)', 'le' => 'P(X ≤ k)', 'lt' => 'P(X < k)', 'ge' => 'P(X ≥ k)', 'gt' => 'P(X > k)', 'between' => 'P(a ≤ X ≤ b)']" selected="eq" />
        <x-calc.field name="a" label="k (or the lower limit a)" value="6" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="Upper limit b" value="9" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 20, 'p' => 0.3, 'mode' => 'eq', 'a' => 6, 'b' => 9],
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
