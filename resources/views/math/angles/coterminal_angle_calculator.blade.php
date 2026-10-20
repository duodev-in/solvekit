<x-calc.page
    title="Coterminal Angle Calculator - SolveKit"
    description="Free coterminal angle calculator: the coterminal angle in [0°, 360°) and other positive and negative coterminal angles, in degrees or radians."
    lede="Find coterminal angles."
    about="Coterminal angles end in the same position, differing by whole turns: θ + 360°k (or θ + 2πk). −765° is coterminal with 315°, 675° and −45°."
    :calc="['engine' => 'mt-tri', 'tool' => 'coterminal', 'fields' => ['angle', 'angle_unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Which angle in [0°, 360°) is coterminal with −765°?', 'answer' => '315 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle" value="-765" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Coterminal angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => -765, 'angle_unit' => 'deg'],
        'Radians' => ['angle' => 7, 'angle_unit' => 'pi'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'coterminal' => ['label' => 'In one turn'],
            'quadrant' => ['label' => 'Quadrant'],
            'list' => ['label' => 'Other coterminal angles'],
            'signs' => ['label' => 'Reference angle'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ + 360°k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
