<x-calc.page
    title="Quarter Circle Calculator - SolveKit"
    description="Free quarter circle calculator: area πr² ÷ 4, arc length and perimeter of a quarter circle."
    lede="Solve a quarter circle."
    about="A quarter circle has area πr²/4, an arc of πr/2 and a perimeter of πr/2 + 2r. A 5 m quarter-circle flower bed covers 19.6 m². Also known as quarter circle area calculator and quarter circle perimeter calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'arc', 'area', 'perim'], 'shape' => 'semicircle', 'want' => 'area', 'part' => 'quarter']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a quarter circle with radius 5?', 'answer' => '19.63495408 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'area' => 'Area A', 'perim' => 'Perimeter P', 'arc' => 'Arc length']" selected="r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:arc" hidden>
            <x-calc.field name="arc" label="Arc length" value="7.85398" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="19.635" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="17.854" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r', 'unit' => 'cm', 'r' => 5, 'd' => 10, 'arc' => 7.85398, 'area' => 19.635, 'perim' => 17.854],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'd' => ['label' => 'Diameter d'],
            'arc' => ['label' => 'Arc length'],
            'area' => ['label' => 'Area A'],
            'perim' => ['label' => 'Perimeter P'],
            'centroid' => ['label' => 'Centroid distance from the straight edge'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = πr² ÷ 4</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
