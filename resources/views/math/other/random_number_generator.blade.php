<x-calc.page
    title="Random Number Generator - SolveKit"
    description="Free random number generator: whole or decimal numbers in any range, with or without repeats, using unbiased cryptographic randomness."
    lede="Generate random numbers."
    about="Each number is drawn uniformly from the range using the browser's cryptographic generator with rejection sampling, so every value is equally likely (no modulo bias). Choose unique values to draw without replacement, like a raffle. Also known as random number picker."
    :calc="['engine' => 'mt-other', 'tool' => 'random', 'fields' => ['min', 'max', 'count', 'places', 'unique']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'Pick 6 different numbers from 1 to 49.', 'answer' => 'Choose 6, no repeats; each draw is different.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="min" label="Minimum" value="1" step="any" />
        <x-calc.field name="max" label="Maximum" value="100" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="count" label="How many" value="5" min="1" max="1000" step="1" />
        <x-calc.field name="places" label="Decimal places" value="0" min="0" max="6" step="1" />
        <x-calc.select name="unique" label="Repeats" :options="['no' => 'Allowed', 'yes' => 'No repeats']" selected="no" />
    </div>

    <x-calc.result label="Random numbers" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['min' => 1, 'max' => 100, 'count' => 5, 'places' => 0, 'unique' => 'no'],
        'Lottery' => ['min' => 1, 'max' => 49, 'count' => 6, 'places' => 0, 'unique' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'list' => ['label' => 'Numbers'],
            'sorted' => ['label' => 'Sorted'],
            'sum' => ['label' => 'Sum'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>uniform choice</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
