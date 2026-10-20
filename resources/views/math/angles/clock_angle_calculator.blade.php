<x-calc.page
    title="Clock Angle Calculator - SolveKit"
    description="Free clock angle calculator: the angle between the hour and minute hands at any time, and when they next overlap."
    lede="Find the angle between clock hands."
    about="The minute hand moves 6° per minute; the hour hand 30° per hour plus 0.5° per minute. At 3:40 the hands are at 240° and 110°, so the angle is 130°. They overlap every 65 5/11 minutes."
    :calc="['engine' => 'mt-tri', 'tool' => 'clock', 'fields' => ['time']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the angle between the hands at 3:40?', 'answer' => '130 °.'],
    ]"
>
    <x-calc.field name="time" label="Time (h:mm or h:mm:ss)" value="3:40" type="text" inputmode="text" />

    <x-calc.result label="Angle between the hands" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['time' => '3:40'],
        'Quarter past' => ['time' => '9:15'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Clock" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'hour' => ['label' => 'Hour hand'],
            'minute' => ['label' => 'Minute hand'],
            'reflex' => ['label' => 'Reflex angle'],
            'overlap' => ['label' => 'Next overlap'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|30h − 5.5m|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
