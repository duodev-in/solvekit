<x-calc.page
    title="Reference Angle Calculator - SolveKit"
    description="Free reference angle calculator: the acute angle to the x-axis for any angle, with its quadrant and the signs of sin, cos and tan."
    lede="Find the reference angle."
    about="The reference angle is the acute angle between the terminal side and the x-axis. It gives trig values up to sign: sin 225° = −sin 45°. Quadrant II: 180° − θ; III: θ − 180°; IV: 360° − θ."
    :calc="['engine' => 'mt-tri', 'tool' => 'coterminal', 'fields' => ['angle', 'angle_unit'], 'want' => 'reference']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the reference angle of 225°?', 'answer' => '45 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle" value="225" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Reference angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 225, 'angle_unit' => 'deg'],
        'Negative' => ['angle' => -150, 'angle_unit' => 'deg'],
        'π form' => ['angle' => 1.75, 'angle_unit' => 'pi'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'coterminal' => ['label' => 'In one turn'],
            'quadrant' => ['label' => 'Quadrant'],
            'list' => ['label' => 'Coterminal angles'],
            'signs' => ['label' => 'Signs'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>quadrant rules</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
