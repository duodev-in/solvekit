<x-calc.page
    title="Cycloid Calculator - SolveKit"
    description="Free cycloid calculator: arc length (8r per arch), area under an arch (3πr²) and the traced point for a rolling circle."
    lede="Explore a cycloid."
    about="A cycloid is the curve traced by a point on the rim of a rolling wheel: x = r(t − sin t), y = r(1 − cos t). One arch is exactly 8r long and encloses 3πr², three times the wheel's area. It is also the fastest slide between two points (the brachistochrone)."
    :calc="['engine' => 'mt-shape', 'tool' => 'cycloid', 'fields' => ['r', 'turns', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How long is one arch of a cycloid made by a wheel of radius 1 m?', 'answer' => '8 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r" label="Radius of the rolling circle" value="1" min="0" step="any" />
        <x-calc.field name="turns" label="Turns rolled" value="1" min="0" step="any" />
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="m" />

    <x-calc.result label="Length of the path traced" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['r' => 1, 'turns' => 1, 'unit' => 'm'],
        'Half turn' => ['r' => 0.35, 'turns' => 0.5, 'unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'arch' => ['label' => 'One arch'],
            'area' => ['label' => 'Area under one arch'],
            'base' => ['label' => 'Distance rolled per turn'],
            'height' => ['label' => 'Arch height'],
            'point' => ['label' => 'Point position now'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>s = 8r per arch</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
