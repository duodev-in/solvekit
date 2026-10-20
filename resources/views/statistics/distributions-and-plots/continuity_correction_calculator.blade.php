<x-calc.page
    title="Continuity Correction Calculator - SolveKit"
    description="Free continuity correction calculator: convert a binomial statement to the normal approximation with the ±0.5 correction, and compare with the exact value."
    lede="Apply a continuity correction."
    about="When a discrete count is approximated by the continuous normal curve, each whole number k covers the interval k − ½ to k + ½."
    :calc="['engine' => 'st-dist', 'tool' => 'continuity', 'fields' => ['n', 'p', 'mode', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the corrected approximation in the example?', 'answer' => '0.865809 (exact 0.865906).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Trials n" value="40" min="1" step="any" />
        <x-calc.field name="p" label="Success probability p" value="0.5" min="0" step="any" />
        <x-calc.select name="mode" label="Statement" :options="['eq' => 'P(X = k)', 'le' => 'P(X ≤ k)', 'lt' => 'P(X < k)', 'ge' => 'P(X ≥ k)', 'gt' => 'P(X > k)']" selected="le" />
        <x-calc.field name="k" label="k" value="23" step="any" />
    </div>

    <x-calc.result label="Normal approximation (corrected)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 40, 'p' => 0.5, 'mode' => 'le', 'k' => 23],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'corrected' => ['label' => 'Corrected statement'],
            'exact' => ['label' => 'Exact binomial'],
            'without' => ['label' => 'Without correction'],
            'check' => ['label' => 'np and n(1 − p)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
