<x-calc.page
    title="Percentage Decrease Calculator - SolveKit"
    description="Free percentage decrease calculator: the percent decrease from one value to another, or the value after a percentage decrease (discounts, losses)."
    lede="Calculate a percentage decrease."
    about="Percentage decrease = (original − new) ÷ original × 100. To reduce a value by p%, multiply it by (1 − p/100): 80 less 25% is 80 × 0.75 = 60. A 50% fall needs a 100% rise to get back to where it started."
    :calc="['engine' => 'mt-percent', 'tool' => 'increase', 'fields' => ['mode', 'a', 'b', 'p'], 'direction' => 'decrease']"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => ''],
        ['name' => 'Enter the values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the decrease from 80 to 60?', 'answer' => '25%.'],
        ['question' => 'What is 80 less 25%?', 'answer' => '60.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['find' => 'The % decrease', 'apply' => 'The new value']" selected="find" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Original value" value="80" type="text" inputmode="decimal" />
        <div data-show-when="mode:find">
            <x-calc.field name="b" label="New value" value="60" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="mode:apply" hidden>
        <x-calc.field name="p" label="Decrease" value="25" type="text" suffix="%" inputmode="decimal" />
    </div>

    <x-calc.result label="Percentage decrease" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'find', 'a' => '80', 'b' => '60', 'p' => '25'],
        'Apply' => ['mode' => 'apply', 'a' => '80', 'b' => '60', 'p' => '25'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'diff' => ['label' => 'Change'],
            'factor' => ['label' => 'Multiplier'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(old − new) ÷ old × 100</li>
            <li>new = old × (1 − p/100)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
