<x-calc.page
    title="Exterior Angles of a Triangle Calculator - SolveKit"
    description="Free exterior angles of a triangle calculator: each exterior angle (180° − interior), which add up to 360°."
    lede="Find the exterior angles."
    about="An exterior angle is formed by one side and the extension of the next. It equals 180° minus the interior angle, and also the sum of the two remote interior angles. The three exterior angles always total 360°."
    :calc="['engine' => 'mt-tri', 'tool' => 'tri_angles', 'fields' => ['angA', 'angB'], 'want' => 'exterior']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What are the exterior angles when A = 50° and B = 60°?', 'answer' => '130°, 120°, 110°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angA" label="Angle A (°)" value="50" min="0" step="any" />
        <x-calc.field name="angB" label="Angle B (°)" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Exterior angles" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angA' => 50, 'angB' => 60],
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
            <li>Exterior = 180° − interior</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
