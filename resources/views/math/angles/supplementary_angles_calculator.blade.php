<x-calc.page
    title="Supplementary Angles Calculator - SolveKit"
    description="Free supplementary angles calculator: the supplement 180° − θ, in degrees and radians."
    lede="Find the supplement of an angle."
    about="Two angles are supplementary when they add up to 180°, like the angles on a straight line: 120° and 60°. Opposite angles of a cyclic quadrilateral are supplementary."
    :calc="['engine' => 'mt-tri', 'tool' => 'comp_supp', 'fields' => ['angle', 'angle_unit'], 'kind' => 'supplement']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the supplement of 120°?', 'answer' => '60 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle" value="120" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Supplement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 120, 'angle_unit' => 'deg'],
        'π form' => ['angle' => 0.25, 'angle_unit' => 'pi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'radians' => ['label' => 'In radians'],
            'given' => ['label' => 'Given angle'],
            'complement' => ['label' => 'Complement'],
            'supplement' => ['label' => 'Supplement'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>180° − θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
