<x-calc.page
    title="Inscribed Angle Calculator - SolveKit"
    description="Free inscribed angle calculator: an inscribed angle is half the central angle on the same arc."
    lede="Find an inscribed or central angle."
    about="An inscribed angle has its vertex on the circle. It is always half the central angle that subtends the same arc, so all inscribed angles on one arc are equal, and an angle in a semicircle is 90°."
    :calc="['engine' => 'mt-tri', 'tool' => 'circle_theorems', 'fields' => ['theorem', 'central', 'inscribed']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What inscribed angle stands on the same arc as a 110° central angle?', 'answer' => '55 °.'],
    ]"
>
    <x-calc.select name="theorem" label="Theorem" :options="['inscribed' => 'Inscribed and central angles']" selected="inscribed" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="central" label="Central angle (°), blank if unknown" value="110" type="text" inputmode="decimal" />
        <x-calc.field name="inscribed" label="Inscribed angle (°), blank if unknown" value="" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Inscribed angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['theorem' => 'inscribed', 'central' => '110', 'inscribed' => ''],
        'Reverse' => ['theorem' => 'inscribed', 'central' => '', 'inscribed' => '40'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'arc' => ['label' => 'Values'],
            'other' => ['label' => 'Check'],
            'semicircle' => ['label' => 'Rule'],
            'cyclic' => ['label' => 'Related fact'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>inscribed = central ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
