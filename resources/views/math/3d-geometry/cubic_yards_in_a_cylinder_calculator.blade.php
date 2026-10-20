<x-calc.page
    title="Cubic Yards In A Cylinder Calculator - SolveKit"
    description="Free cubic yards in a cylinder calculator: the volume of a round column, pier or hole in yd³ (for concrete or soil)."
    lede="Find a cylinder's volume in cubic yards."
    about="Concrete and soil are sold by the cubic yard (27 ft³). Measure in feet; the yd³ figure is in the conversions. A 2 ft wide, 10 ft deep pier hole needs 1.16 yd³."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'd', 'vol', 'lat', 'surf', 'circ'], 'shape' => 'cylinder', 'want' => 'vol', 'volumeIn' => 'yd3']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How many cubic yards fill a hole 2 ft across and 10 ft deep?', 'answer' => '1.163552835 yd³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Radius r and height h', 'd_h' => 'Diameter and height h', 'vol_r' => 'Volume V and radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and radius r', 'lat_h' => 'Lateral surface area and height h', 'surf_r' => 'Total surface area and radius r', 'circ_h' => 'Base circumference and height h']" selected="d_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="ft" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,vol_r,lat_r,surf_r" hidden>
            <x-calc.field name="r" label="Radius r" value="1" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,vol_h,lat_h,circ_h" hidden>
            <x-calc.field name="h" label="Height h" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Diameter" value="2" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="31.4159" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:lat_r,lat_h" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="62.8319" min="0" step="any" />
        </div>
        <div data-show-when="given:surf_r" hidden>
            <x-calc.field name="surf" label="Total surface area (unit²)" value="69.115" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ_h" hidden>
            <x-calc.field name="circ" label="Base circumference" value="6.28319" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'd_h', 'unit' => 'ft', 'r' => 1, 'h' => 10, 'd' => 2, 'vol' => 31.4159, 'lat' => 62.8319, 'surf' => 69.115, 'circ' => 6.28319],
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
            <li>yd³ = ft³ ÷ 27</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
