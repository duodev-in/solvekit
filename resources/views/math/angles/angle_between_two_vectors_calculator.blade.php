<x-calc.page
    title="Angle Between Two Vectors Calculator - SolveKit"
    description="Free angle between two vectors calculator: θ = acos(u·v ÷ |u||v|) in 2D or 3D, with the dot and cross products."
    lede="Find the angle between vectors."
    about="The dot product gives the angle: cos θ = (u · v)/(|u||v|). Perpendicular vectors have u · v = 0; parallel ones have |cos θ| = 1. In 3D the cross product is perpendicular to both."
    :calc="['engine' => 'mt-tri', 'tool' => 'angle_vectors', 'fields' => ['u', 'v']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the angle between (3, 4) and (4, 3)?', 'answer' => '16.2602047083 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Vector u" value="3, 4" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="4, 3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '3, 4', 'v' => '4, 3'],
        '3D' => ['u' => '1, 2, 3', 'v' => '-2, 0, 5'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'dot' => ['label' => 'Dot product u · v'],
            'norms' => ['label' => 'Lengths'],
            'cos' => ['label' => 'cos θ'],
            'cross' => ['label' => 'Cross product'],
            'relation' => ['label' => 'Relation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cos θ = u·v ÷ (|u||v|)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
