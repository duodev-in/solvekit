<x-calc.page
    title="Rotation Calculator - SolveKit"
    description="Free rotation calculator: rotate a point by any angle about the origin or another centre, exact for 90°, 180° and 270°."
    lede="Rotate a point."
    about="Rotating (x, y) by θ counter-clockwise about the origin gives (x cos θ − y sin θ, x sin θ + y cos θ). The quarter turns have simple rules: 90° maps (x, y) to (−y, x). For another centre, shift it to the origin first."
    :calc="['engine' => 'mt-coord', 'tool' => 'rotate', 'fields' => ['x', 'y', 'angle', 'direction', 'cx', 'cy']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Rotate (3, 1) by 90° counter-clockwise about the origin.', 'answer' => '(−1, 3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Point x" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="y" label="Point y" value="1" type="text" inputmode="decimal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="angle" label="Angle (°)" value="90" step="any" />
        <x-calc.select name="direction" label="Direction" :options="['ccw' => 'Counter-clockwise', 'cw' => 'Clockwise']" selected="ccw" />
        <x-calc.field name="cx" label="Centre x" value="0" type="text" inputmode="decimal" />
    </div>

    <x-calc.field name="cy" label="Centre y" value="0" type="text" inputmode="decimal" />

    <x-calc.result label="Rotated point" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '3', 'y' => '1', 'angle' => 90, 'direction' => 'ccw', 'cx' => '0', 'cy' => '0'],
        'Centre' => ['x' => '3', 'y' => '1', 'angle' => 30, 'direction' => 'cw', 'cx' => '1', 'cy' => '1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'rule' => ['label' => 'Rule'],
            'decimal' => ['label' => 'Decimal'],
            'distance' => ['label' => 'Distance to the centre'],
            'matrix' => ['label' => 'Rotation matrix'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x′ = x cos θ − y sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
