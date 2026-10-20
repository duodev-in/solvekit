<x-calc.page
    title="Radius of a Circle Calculator - SolveKit"
    description="Free radius of a circle calculator: r = d ÷ 2, C ÷ 2π or √(A ÷ π)."
    lede="Find the radius of a circle."
    about="The radius is half the diameter. From the area, r = √(A/π): a 50 m² circle has radius 3.989 m."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'circ', 'area'], 'shape' => 'circle', 'want' => 'r']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the radius of a circle with area 50?', 'answer' => '3.989422804 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'circ' => 'Circumference C', 'area' => 'Area A']" selected="area" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="3.98942" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="7.97885" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ" hidden>
            <x-calc.field name="circ" label="Circumference C" value="25.0663" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="50" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Radius r" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'area', 'unit' => 'cm', 'r' => 3.98942, 'd' => 7.97885, 'circ' => 25.0663, 'area' => 50],
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
            <li>r = √(A/π)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
