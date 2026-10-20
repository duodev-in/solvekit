<x-calc.page
    title="Round to the Nearest Thousand Calculator - SolveKit"
    description="Free round to the nearest thousand calculator: round whole numbers to thousands, with the method and the values above and below."
    lede="Round to the nearest thousand."
    about="Look at the hundreds digit: 5 or more rounds up. 48,762 → 49,000. Halves round away from zero by default; banker's rounding is also available."
    :calc="['engine' => 'mt-number', 'tool' => 'rounding', 'fields' => ['x', 'place', 'method', 'sig']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 48,762 rounded to the nearest thousand?', 'answer' => '49,000.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="48,762" type="text" inputmode="decimal" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="place" label="Round to" :options="['1000' => 'Thousands', '100' => 'Hundreds', '10' => 'Tens', '1' => 'Whole number', '0.1' => 'Tenths', '0.01' => 'Hundredths', '0.001' => 'Thousandths', '0.0001' => 'Ten-thousandths', '0.05' => 'Nearest 0.05', '0.25' => 'Nearest quarter', 'sig' => 'Significant figures']" selected="1000" />
        <x-calc.select name="method" label="Method" :options="['half-up' => 'Half away from zero', 'half-even' => 'Half to even (banker\'s)', 'half-down' => 'Half towards zero', 'up' => 'Always up (ceiling)', 'down' => 'Always down (floor)']" selected="half-up" />
    </div>

    <div data-show-when="place:sig" hidden>
        <x-calc.field name="sig" label="Significant figures" value="3" min="1" max="40" step="1" />
    </div>

    <x-calc.result label="Rounded value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '48,762', 'place' => '1000', 'method' => 'half-up', 'sig' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'method' => ['label' => 'Method'],
            'up' => ['label' => 'Rounded up'],
            'down' => ['label' => 'Rounded down'],
            'truncated' => ['label' => 'Truncated'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>round(x, step) = step × round(x ÷ step)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
