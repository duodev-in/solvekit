<x-calc.page
    title="Percentage Increase Calculator - SolveKit"
    description="Free percentage increase calculator: the percent increase from one value to another, or the new value after increasing by a percentage."
    lede="Calculate a percentage increase."
    about="Percentage increase = (new − original) ÷ original × 100. To increase a value by p%, multiply it by (1 + p/100): 80 increased by 15% is 80 × 1.15 = 92. Two increases of 10% make 21% in total, not 20%, because the second applies to the larger value."
    :calc="['engine' => 'mt-percent', 'tool' => 'increase', 'fields' => ['mode', 'a', 'b', 'p']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => ''],
        ['name' => 'Enter the values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the increase from 80 to 92?', 'answer' => '15%.'],
        ['question' => 'What is 80 increased by 15%?', 'answer' => '92.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['find' => 'The % increase', 'apply' => 'The new value']" selected="find" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Original value" value="80" type="text" inputmode="decimal" />
        <div data-show-when="mode:find">
            <x-calc.field name="b" label="New value" value="92" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="mode:apply" hidden>
        <x-calc.field name="p" label="Increase" value="15" type="text" suffix="%" inputmode="decimal" />
    </div>

    <x-calc.result label="Percentage increase" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'find', 'a' => '80', 'b' => '92', 'p' => '15'],
        'Apply' => ['mode' => 'apply', 'a' => '80', 'b' => '92', 'p' => '15'],
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
            <li>(new − old) ÷ old × 100</li>
            <li>new = old × (1 + p/100)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
