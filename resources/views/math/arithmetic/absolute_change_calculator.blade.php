<x-calc.page
    title="Absolute Change Calculator - SolveKit"
    description="Free absolute change calculator: the difference between a final and an initial value, with the relative change."
    lede="Find the absolute change."
    about="Absolute change = final − initial, in the same units as the values: a price going from 40 to 52 changes by +12. The relative change (+30%) compares it with the start."
    :calc="['engine' => 'mt-arith', 'tool' => 'abs_change', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the change from 40 to 52?', 'answer' => '+12.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Initial value" value="40" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Final value" value="52" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Absolute change" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '40', 'b' => '52'],
        'Fall' => ['a' => '3.2', 'b' => '2.9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'relative' => ['label' => 'Relative change'],
            'size' => ['label' => 'Size of the change'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Δ = final − initial</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
