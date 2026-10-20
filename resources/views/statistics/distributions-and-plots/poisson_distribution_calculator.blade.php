<x-calc.page
    title="Poisson Distribution Calculator - SolveKit"
    description="Free Poisson distribution calculator: P(X = k) and cumulative probabilities for events at average rate λ."
    lede="Find Poisson probabilities."
    about="The Poisson distribution counts random events in a fixed interval when they happen independently at a constant average rate."
    :calc="['engine' => 'st-dist', 'tool' => 'poisson', 'fields' => ['lambda', 'mode', 'a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(X = 2) for λ = 4?', 'answer' => '0.14652511.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lambda" label="Average rate λ" value="4" min="0" step="any" />
        <x-calc.select name="mode" label="Find" :options="['eq' => 'P(X = k)', 'le' => 'P(X ≤ k)', 'lt' => 'P(X < k)', 'ge' => 'P(X ≥ k)', 'gt' => 'P(X > k)', 'between' => 'P(a ≤ X ≤ b)']" selected="eq" />
        <x-calc.field name="a" label="k (or the lower limit a)" value="2" step="any" />
        <div data-show-when="mode:between">
            <x-calc.field name="b" label="Upper limit b" value="5" step="any" />
        </div>
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lambda' => 4, 'mode' => 'eq', 'a' => 2, 'b' => 5],
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
