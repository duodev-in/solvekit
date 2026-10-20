<x-calc.page
    title="Circumference Calculator - SolveKit"
    description="Free circumference calculator: C = 2πr = πd from the radius, diameter or area."
    lede="Find the circumference of a circle."
    about="The circumference is the distance around a circle: C = 2πr = πd. A wheel with diameter 70 cm travels 219.9 cm per turn. Also known as circle length calculator and circle perimeter calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'circ', 'area'], 'shape' => 'circle', 'want' => 'circ']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the circumference of a circle with diameter 70 cm?', 'answer' => '219.9114858 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'circ' => 'Circumference C', 'area' => 'Area A']" selected="d" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="35" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="70" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ" hidden>
            <x-calc.field name="circ" label="Circumference C" value="219.911" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="3848.45" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Circumference C" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'd', 'unit' => 'cm', 'r' => 35, 'd' => 70, 'circ' => 219.911, 'area' => 3848.45],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'd' => ['label' => 'Diameter d'],
            'circ' => ['label' => 'Circumference C'],
            'area' => ['label' => 'Area A'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C = πd</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
