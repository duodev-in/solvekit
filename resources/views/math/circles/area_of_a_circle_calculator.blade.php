<x-calc.page
    title="Area of a Circle Calculator - SolveKit"
    description="Free area of a circle calculator: A = πr² from the radius, diameter or circumference."
    lede="Find the area of a circle."
    about="The area of a circle is π times the radius squared. From the diameter, A = πd²/4; from the circumference, A = C²/4π. Doubling the radius makes the area four times larger."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'circ', 'area'], 'shape' => 'circle', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a circle with radius 3?', 'answer' => '28.27433388 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'circ' => 'Circumference C', 'area' => 'Area A']" selected="r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ" hidden>
            <x-calc.field name="circ" label="Circumference C" value="18.8496" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="28.2743" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r', 'unit' => 'cm', 'r' => 3, 'd' => 6, 'circ' => 18.8496, 'area' => 28.2743],
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
            <li>A = πr²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
