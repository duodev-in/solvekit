<x-calc.page
    title="Triangle Sum Theorem Calculator - SolveKit"
    description="Free triangle sum theorem calculator: A + B + C = 180°, find the third angle and check a set of angles."
    lede="Apply the triangle sum theorem."
    about="The triangle sum theorem says the three interior angles total 180°. It follows from drawing a line through one vertex parallel to the opposite side: the alternate angles fill a straight line."
    :calc="['engine' => 'mt-tri', 'tool' => 'tri_angles', 'fields' => ['angA', 'angB']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'If A = 35° and B = 75°, what is C?', 'answer' => '70 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angA" label="Angle A (°)" value="35" min="0" step="any" />
        <x-calc.field name="angB" label="Angle B (°)" value="75" min="0" step="any" />
    </div>

    <x-calc.result label="Third angle C" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angA' => 35, 'angB' => 75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Side ratio'],
            'exterior' => ['label' => 'Exterior angles'],
            'kind' => ['label' => 'Type'],
            'radians' => ['label' => 'In radians'],
            'remote' => ['label' => 'Exterior angle theorem'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A + B + C = 180°</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
