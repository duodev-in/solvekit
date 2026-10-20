<x-calc.page
    title="Star Shape Calculator - SolveKit"
    description="Free star shape calculator: inner radius, edge length, perimeter, area and tip angle of a regular star with 5 to 50 points."
    lede="Solve a regular star."
    about="A regular star {n/2} joins every second point of a regular n-gon. For a five-pointed star with outer radius R the inner radius is R cos 72°/cos 36° ≈ 0.382R, each tip is 36° and the area is about 1.123R²."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['n', 'given', 'unit', 'outer', 'inner', 'edge', 'area'], 'shape' => 'star', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a five-pointed star with outer radius 10?', 'answer' => '112.2569941 cm².'],
    ]"
>
    <x-calc.field name="n" label="Number of points n" value="5" min="5" max="50" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['outer' => 'Outer radius R', 'inner' => 'Inner radius r', 'edge' => 'Edge length', 'area' => 'Area']" selected="outer" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:outer" hidden>
            <x-calc.field name="outer" label="Outer radius R" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:inner" hidden>
            <x-calc.field name="inner" label="Inner radius r" value="3.81966" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:edge" hidden>
            <x-calc.field name="edge" label="Edge length" value="7.26543" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="112.257" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 5, 'given' => 'outer', 'unit' => 'cm', 'outer' => 10, 'inner' => 3.81966, 'edge' => 7.26543, 'area' => 112.257],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'outer' => ['label' => 'Outer radius R'],
            'inner' => ['label' => 'Inner radius r'],
            'edge' => ['label' => 'Edge length'],
            'perim' => ['label' => 'Perimeter'],
            'area' => ['label' => 'Area'],
            'tip' => ['label' => 'Tip angle'],
            'chord' => ['label' => 'Chord (tip to tip line)'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = n R r sin(π/n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
