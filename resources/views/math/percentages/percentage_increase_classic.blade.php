<x-calc.page
    title="Percentage Increase Classic - SolveKit"
    description="Free classic percentage increase calculator: add a percentage to a number (value plus p%), with the amount added and the multiplier."
    lede="Add a percentage to a number."
    about="The classic percentage increase adds p% of a value to itself: new = value × (1 + p/100). For example 250 increased by 8% is 250 + 20 = 270. The multiplier form is handy for repeated increases: three 8% increases multiply by 1.08³."
    :calc="['engine' => 'mt-percent', 'tool' => 'increase', 'fields' => ['mode', 'a', 'b', 'p']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => ''],
        ['name' => 'Enter the values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 250 increased by 8%?', 'answer' => '270 (250 + 20).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['find' => 'The % increase', 'apply' => 'The new value']" selected="apply" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Original value" value="250" type="text" inputmode="decimal" />
        <div data-show-when="mode:find" hidden>
            <x-calc.field name="b" label="New value" value="92" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="mode:apply">
        <x-calc.field name="p" label="Increase" value="8" type="text" suffix="%" inputmode="decimal" />
    </div>

    <x-calc.result label="Percentage increase" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'apply', 'a' => '250', 'b' => '92', 'p' => '8'],
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
