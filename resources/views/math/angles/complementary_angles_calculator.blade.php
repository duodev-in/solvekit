<x-calc.page
    title="Complementary Angles Calculator - SolveKit"
    description="Free complementary angles calculator: the complement 90° − θ, in degrees and radians."
    lede="Find the complement of an angle."
    about="Two angles are complementary when they add up to 90°: 35° and 55°. In a right triangle the two acute angles are complementary, which is why sin θ = cos(90° − θ)."
    :calc="['engine' => 'mt-tri', 'tool' => 'comp_supp', 'fields' => ['angle', 'angle_unit'], 'kind' => 'complement']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the complement of 35°?', 'answer' => '55 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle" value="35" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Complement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 35, 'angle_unit' => 'deg'],
        'Radians' => ['angle' => 0.5, 'angle_unit' => 'rad'],
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
            <li>90° − θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
