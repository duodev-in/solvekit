<x-calc.page
    title="Segment Addition Postulate Calculator - SolveKit"
    description="Free segment addition postulate calculator: solve AB + BC = AC for x, or find a missing segment length."
    lede="Use the segment addition postulate."
    about="If B lies on segment AC, then AB + BC = AC. With expressions such as AB = 2x + 3, BC = x − 1 and AC = 20, add, solve for x (x = 6) and substitute back to get each length. With plain numbers, leave the unknown blank."
    :calc="['engine' => 'mt-shape', 'tool' => 'segment_addition', 'fields' => ['ab', 'bc', 'ac']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'If AB = 2x + 3, BC = x − 1 and AC = 20, what is x?', 'answer' => 'x = 6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ab" label="AB" value="2x + 3" type="text" inputmode="text" />
        <x-calc.field name="bc" label="BC" value="x - 1" type="text" inputmode="text" />
        <x-calc.field name="ac" label="AC" value="20" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Solution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ab' => '2x + 3', 'bc' => 'x - 1', 'ac' => '20'],
        'Numbers' => ['ab' => '7.5', 'bc' => '', 'ac' => '12'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'x' => ['label' => 'x'],
            'ab' => ['label' => 'AB'],
            'bc' => ['label' => 'BC'],
            'ac' => ['label' => 'AC'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AB + BC = AC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
