<x-calc.page
    title="Height of a Cylinder Calculator - SolveKit"
    description="Free height of a cylinder calculator: h = V ÷ πr², or from the lateral or total area."
    lede="Find a cylinder's height."
    about="Divide the volume by the base area: h = V/(πr²). A 1-litre jug with radius 5 cm must be 12.7 cm tall."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'd', 'vol', 'lat', 'surf', 'circ'], 'shape' => 'cylinder', 'want' => 'h']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How tall is a 1,000 cm³ cylinder with radius 5 cm?', 'answer' => '12.73239545 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Radius r and height h', 'd_h' => 'Diameter and height h', 'vol_r' => 'Volume V and radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and radius r', 'lat_h' => 'Lateral surface area and height h', 'surf_r' => 'Total surface area and radius r', 'circ_h' => 'Base circumference and height h']" selected="vol_r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,vol_r,lat_r,surf_r" hidden>
            <x-calc.field name="r" label="Radius r" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,vol_h,lat_h,circ_h" hidden>
            <x-calc.field name="h" label="Height h" value="12.7324" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Diameter" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="1000" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:lat_r,lat_h" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="400" min="0" step="any" />
        </div>
        <div data-show-when="given:surf_r" hidden>
            <x-calc.field name="surf" label="Total surface area (unit²)" value="557.08" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ_h" hidden>
            <x-calc.field name="circ" label="Base circumference" value="31.4159" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Height h" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol_r', 'unit' => 'cm', 'r' => 5, 'h' => 12.7324, 'd' => 10, 'vol' => 1000, 'lat' => 400, 'surf' => 557.08, 'circ' => 31.4159],
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
            <li>h = V ÷ πr²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
