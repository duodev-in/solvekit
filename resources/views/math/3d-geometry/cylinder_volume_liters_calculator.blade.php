<x-calc.page
    title="Cylinder Volume Liters Calculator - SolveKit"
    description="Free cylinder volume in litres calculator: the capacity of a round container in L from its diameter and height in cm."
    lede="Find a cylinder's capacity in litres."
    about="1 litre = 1,000 cm³. A pot 24 cm across and 15 cm deep holds π × 12² × 15 = 6,786 cm³ = 6.79 L."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'd', 'vol', 'lat', 'surf', 'circ'], 'shape' => 'cylinder', 'want' => 'vol', 'volumeIn' => 'L']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How many litres does a pot 24 cm across and 15 cm deep hold?', 'answer' => '6.785840132 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Radius r and height h', 'd_h' => 'Diameter and height h', 'vol_r' => 'Volume V and radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and radius r', 'lat_h' => 'Lateral surface area and height h', 'surf_r' => 'Total surface area and radius r', 'circ_h' => 'Base circumference and height h']" selected="d_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,vol_r,lat_r,surf_r" hidden>
            <x-calc.field name="r" label="Radius r" value="12" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,vol_h,lat_h,circ_h" hidden>
            <x-calc.field name="h" label="Height h" value="15" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Diameter" value="24" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="6785.84" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:lat_r,lat_h" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="1130.97" min="0" step="any" />
        </div>
        <div data-show-when="given:surf_r" hidden>
            <x-calc.field name="surf" label="Total surface area (unit²)" value="2035.75" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ_h" hidden>
            <x-calc.field name="circ" label="Base circumference" value="75.3982" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'd_h', 'unit' => 'cm', 'r' => 12, 'h' => 15, 'd' => 24, 'vol' => 6785.84, 'lat' => 1130.97, 'surf' => 2035.75, 'circ' => 75.3982],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'h' => ['label' => 'Height h'],
            'd' => ['label' => 'Diameter'],
            'vol' => ['label' => 'Volume V'],
            'lat' => ['label' => 'Lateral surface area'],
            'base' => ['label' => 'Base area'],
            'surf' => ['label' => 'Total surface area'],
            'circ' => ['label' => 'Base circumference'],
            'diag' => ['label' => 'Longest straight line inside'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = πr²h ÷ 1,000 cm³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
