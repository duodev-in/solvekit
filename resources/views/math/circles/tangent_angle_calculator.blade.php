<x-calc.page
    title="Tangent Angle Calculator - SolveKit"
    description="Free tangent angle calculator: the angle between two tangents from an outside point, 2 asin(r ÷ d)."
    lede="Find the angle between two tangents."
    about="The two tangents from a point P make an angle of 2 asin(r/d), and the angle between the radii to the touching points is its supplement. From 13 units away a circle of radius 5 spans 45.24°."
    :calc="['engine' => 'mt-tri', 'tool' => 'tangent', 'fields' => ['r', 'd', 'unit'], 'want' => 'angle', 'given' => 'distance']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What angle do the tangents make from 13 away to a circle of radius 5?', 'answer' => '45.2397298961 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="r" label="Radius r" value="5" min="0" step="any" />
        <x-calc.field name="d" label="Distance from the centre d" value="13" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <x-calc.result label="Angle between the tangents" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['r' => 5, 'd' => 13, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'length' => ['label' => 'Tangent length'],
            'angle' => ['label' => 'Angle between the tangents'],
            'central' => ['label' => 'Angle at the centre'],
            'points' => ['label' => 'Touching points'],
            'distance' => ['label' => 'Distance to the centre'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = 2 asin(r/d)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
