<x-calc.page
    title="Triangle Angle Calculator - SolveKit"
    description="Free triangle angle calculator: the third angle from two (A + B + C = 180°), exterior angles and the triangle type."
    lede="Find the missing angle."
    about="The interior angles of any triangle add up to 180°, so the third angle is 180° minus the other two. Each exterior angle is 180° minus its interior angle, and equals the sum of the two remote interior angles. Also known as triangle degree calculator and interior and exterior triangle angles calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'tri_angles', 'fields' => ['angA', 'angB']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Two angles are 50° and 60°. What is the third?', 'answer' => '70 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angA" label="Angle A (°)" value="50" min="0" step="any" />
        <x-calc.field name="angB" label="Angle B (°)" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Third angle C" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angA' => 50, 'angB' => 60],
        'Right' => ['angA' => 90, 'angB' => 35],
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
