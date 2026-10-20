<x-calc.page
    title="Cylinder Volume Gallons Calculator - SolveKit"
    description="Free cylinder volume in gallons calculator: the capacity of a round tank or drum in US gallons from its diameter and height."
    lede="Find a cylinder's capacity in gallons."
    about="Measure the inside diameter and height, compute πr²h and convert: 1 US gallon = 231 in³. A drum 22.5 in across and 33.5 in tall holds about 57.5 gallons."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'd', 'vol', 'lat', 'surf', 'circ'], 'shape' => 'cylinder', 'want' => 'vol', 'volumeIn' => 'gal']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons does a drum 22.5 in across and 33.5 in tall hold?', 'answer' => '57.66174016 US gal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Radius r and height h', 'd_h' => 'Diameter and height h', 'vol_r' => 'Volume V and radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and radius r', 'lat_h' => 'Lateral surface area and height h', 'surf_r' => 'Total surface area and radius r', 'circ_h' => 'Base circumference and height h']" selected="d_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="in" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,vol_r,lat_r,surf_r" hidden>
            <x-calc.field name="r" label="Radius r" value="11.25" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,vol_h,lat_h,circ_h" hidden>
            <x-calc.field name="h" label="Height h" value="33.5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Diameter" value="22.5" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="13319.9" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:lat_r,lat_h" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="2367.98" min="0" step="any" />
        </div>
        <div data-show-when="given:surf_r" hidden>
            <x-calc.field name="surf" label="Total surface area (unit²)" value="3163.19" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ_h" hidden>
            <x-calc.field name="circ" label="Base circumference" value="70.6858" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'd_h', 'unit' => 'in', 'r' => 11.25, 'h' => 33.5, 'd' => 22.5, 'vol' => 13319.9, 'lat' => 2367.98, 'surf' => 3163.19, 'circ' => 70.6858],
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
            <li>gal = πr²h ÷ 231 in³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
