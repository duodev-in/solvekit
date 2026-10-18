<x-calc.page
    title="Bolt Circle Calculator - SolveKit"
    description="Free bolt circle calculator: X and Y coordinates of equally spaced holes on a circle, with the spacing between holes."
    lede="Work out hole positions on a bolt circle."
    about="Holes on a circle of radius r at angles θₖ = start + 360° × k ÷ n sit at X = cx + r cos θₖ and Y = cy + r sin θₖ. The straight distance between neighbouring holes is 2r sin(180° ÷ n). Angles are measured counterclockwise from the +X axis."
    :calc="['engine' => 'con-mech', 'tool' => 'bolt_circle', 'fields' => ['units', 'diameter', 'holes', 'start', 'cx', 'cy']]"
    :how-to="[
        ['name' => 'Enter the circle and holes', 'text' => 'Diameter, number and starting angle.'],
        ['name' => 'Enter the center', 'text' => 'For coordinates on your part.'],
    ]"
    :faqs="[
        ['question' => 'How far apart are 6 holes on a 4 in circle?', 'answer' => '2 in (the chord equals the radius for six holes).'],
        ['question' => 'How do I start at 12 o\'clock?', 'answer' => 'Set the first hole angle to 90°.'],
        ['question' => 'Which way do angles run?', 'answer' => 'Counterclockwise from the +X axis.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="units" label="Units" :options="['in' => 'Inches', 'mm' => 'Millimeters']" selected="in" />
        <x-calc.field name="diameter" label="Bolt circle diameter" value="4" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="holes" label="Holes" value="6" min="2" step="1" />
        <x-calc.field name="start" label="First hole angle" value="0" suffix="°" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cx" label="Center X" value="0" />
        <x-calc.field name="cy" label="Center Y" value="0" />
    </div>

    <x-calc.result label="Spacing between holes" />

    <x-calc.options :examples="[
        '6 holes on 4 in' => ['units' => 'in', 'diameter' => 4, 'holes' => 6, 'start' => 0, 'cx' => 0, 'cy' => 0],
        '8 holes, start at 22.5°' => ['units' => 'mm', 'diameter' => 120, 'holes' => 8, 'start' => 22.5, 'cx' => 50, 'cy' => 50],
        '5 lug wheel 4.5 in' => ['units' => 'in', 'diameter' => 4.5, 'holes' => 5, 'start' => 90, 'cx' => 0, 'cy' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'angle' => ['label' => 'Angle between holes'],
            'chord' => ['label' => 'Spacing'],
            'radius' => ['label' => 'Radius'],
        ]" />
        <x-calc.quick-ref heading="Hole coordinates" name="holes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>X = cx + r cos θ, Y = cy + r sin θ</li>
            <li>spacing = 2 r sin(180° ÷ n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
