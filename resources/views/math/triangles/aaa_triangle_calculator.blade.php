<x-calc.page
    title="AAA Triangle Calculator - SolveKit"
    description="Free AAA triangle calculator: check three angles, find the third from two, and the side ratios they fix (the size is free)."
    lede="Solve a triangle from its angles."
    about="Angles alone fix the shape of a triangle but not its size: every AAA triangle is similar to the others. The sides are in the ratio sin A : sin B : sin C. Enter two angles; the third is 180° minus their sum."
    :calc="['engine' => 'mt-tri', 'tool' => 'tri_angles', 'fields' => ['angA', 'angB']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A = 50° and B = 60°. What else is fixed?', 'answer' => 'C = 70 ° and the sides are in the ratio a : b : c = sin A : sin B : sin C = 1 : 1.1305159 : 1.2266816.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angA" label="Angle A (°)" value="50" min="0" step="any" />
        <x-calc.field name="angB" label="Angle B (°)" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Third angle C" />

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
            <li>a : b : c = sin A : sin B : sin C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
