<x-calc.page
    title="Rounding Calculator - SolveKit"
    description="Free rounding calculator: round to any place (thousands to millionths), a multiple, or significant figures, with half-up, half-even (banker's), up, down and truncation."
    lede="Round a number."
    about="Rounding replaces a number with the nearest value at a chosen place. The usual school rule rounds halves away from zero (2.5 → 3, −2.5 → −3); banker's rounding sends halves to the even digit (2.5 → 2) to avoid bias. Rounding is exact here, so 1.005 rounds to 1.01."
    :calc="['engine' => 'mt-number', 'tool' => 'rounding', 'fields' => ['x', 'place', 'method', 'sig']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3.14159 to the nearest hundredth?', 'answer' => '3.14.'],
        ['question' => 'What is 2.5 with banker\'s rounding?', 'answer' => '2.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="3.14159" type="text" inputmode="decimal" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="place" label="Round to" :options="['1000' => 'Thousands', '100' => 'Hundreds', '10' => 'Tens', '1' => 'Whole number', '0.1' => 'Tenths', '0.01' => 'Hundredths', '0.001' => 'Thousandths', '0.0001' => 'Ten-thousandths', '0.05' => 'Nearest 0.05', '0.25' => 'Nearest quarter', 'sig' => 'Significant figures']" selected="0.01" />
        <x-calc.select name="method" label="Method" :options="['half-up' => 'Half away from zero', 'half-even' => 'Half to even (banker\'s)', 'half-down' => 'Half towards zero', 'up' => 'Always up (ceiling)', 'down' => 'Always down (floor)']" selected="half-up" />
    </div>

    <div data-show-when="place:sig" hidden>
        <x-calc.field name="sig" label="Significant figures" value="3" min="1" max="40" step="1" />
    </div>

    <x-calc.result label="Rounded value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '3.14159', 'place' => '0.01', 'method' => 'half-up', 'sig' => 3],
        'Banker' => ['x' => '2.5', 'place' => '1', 'method' => 'half-even', 'sig' => 3],
        'Sig figs' => ['x' => '0.0045678', 'place' => 'sig', 'method' => 'half-up', 'sig' => 3],
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
