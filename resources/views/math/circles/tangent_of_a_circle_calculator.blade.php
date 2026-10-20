<x-calc.page
    title="Tangent of a Circle Calculator - SolveKit"
    description="Free tangent of a circle calculator: tangent length √(d² − r²), touching points and tangent line equations from an outside point."
    lede="Find tangents from a point."
    about="From a point outside a circle two tangents can be drawn, equal in length √(d² − r²), where d is the distance to the centre. Each meets the radius at a right angle. With coordinates, the touching points and line equations are given."
    :calc="['engine' => 'mt-tri', 'tool' => 'tangent', 'fields' => ['given', 'r', 'd', 'unit', 'h', 'k', 'px', 'py']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How long are the tangents to a circle of radius 5 from a point 13 away?', 'answer' => '12 cm.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['distance' => 'The radius and the distance to the point', 'point' => 'Coordinates of the centre and the point']" selected="distance" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="r" label="Radius r" value="5" min="0" step="any" />
        <div data-show-when="given:distance" hidden>
            <x-calc.field name="d" label="Distance from the centre d" value="13" min="0" step="any" />
        </div>
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div data-show-when="given:point" hidden>
            <x-calc.field name="h" label="Centre x" value="0" step="any" />
        </div>
        <div data-show-when="given:point" hidden>
            <x-calc.field name="k" label="Centre y" value="0" step="any" />
        </div>
        <div data-show-when="given:point" hidden>
            <x-calc.field name="px" label="Point x" value="13" step="any" />
        </div>
        <div data-show-when="given:point" hidden>
            <x-calc.field name="py" label="Point y" value="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Tangent length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'distance', 'r' => 5, 'd' => 13, 'unit' => 'cm', 'h' => 0, 'k' => 0, 'px' => 13, 'py' => 0],
        'Coordinates' => ['given' => 'point', 'r' => 2, 'd' => 13, 'unit' => 'cm', 'h' => 1, 'k' => 1, 'px' => 5, 'py' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'length' => ['label' => 'Tangent length'],
            'angle' => ['label' => 'Angle between the tangents'],
            'central' => ['label' => 'Angle at the centre'],
            'points' => ['label' => 'Touching points'],
            'lines' => ['label' => 'Tangent lines'],
            'distance' => ['label' => 'Distance to the centre'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t = √(d² − r²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
