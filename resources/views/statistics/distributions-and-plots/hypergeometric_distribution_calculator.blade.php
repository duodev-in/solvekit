<x-calc.page
    title="Hypergeometric Distribution Calculator - SolveKit"
    description="Free hypergeometric distribution calculator: probabilities for draws without replacement from a finite population."
    lede="Find hypergeometric probabilities."
    about="The hypergeometric distribution counts successes when sampling without replacement, as in card games or quality inspections."
    :calc="['engine' => 'st-dist', 'tool' => 'hypergeometric', 'fields' => ['N', 'K', 'n', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X = 2) for N = 50, K = 12, n = 10?', 'answer' => '0.31420785.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="N" label="Population size N" value="50" min="1" step="any" />
        <x-calc.field name="K" label="Successes in the population K" value="12" min="0" step="any" />
        <x-calc.field name="n" label="Draws n (without replacement)" value="10" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['eq' => 'P(X = k)', 'le' => 'P(X ≤ k)', 'lt' => 'P(X < k)', 'ge' => 'P(X ≥ k)', 'gt' => 'P(X > k)', 'between' => 'P(a ≤ X ≤ b)']" selected="eq" />
        <x-calc.field name="a" label="k (or the lower limit a)" value="2" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="Upper limit b" value="4" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['N' => 50, 'K' => 12, 'n' => 10, 'mode' => 'eq', 'a' => 2, 'b' => 4],
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
