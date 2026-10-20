<x-calc.page
    title="Diameter of a Cylinder Calculator - SolveKit"
    description="Free diameter of a cylinder calculator: d from the volume and height, d = 2√(V ÷ πh)."
    lede="Find a cylinder's diameter."
    about="Rearranging V = πr²h gives r = √(V/πh) and d = 2r. A 1-litre can 12 cm tall must be 10.3 cm across."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'd', 'vol', 'lat', 'surf', 'circ'], 'shape' => 'cylinder', 'want' => 'd']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How wide is a 1,000 cm³ can that is 12 cm tall?', 'answer' => '10.30064539 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Radius r and height h', 'd_h' => 'Diameter and height h', 'vol_r' => 'Volume V and radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and radius r', 'lat_h' => 'Lateral surface area and height h', 'surf_r' => 'Total surface area and radius r', 'circ_h' => 'Base circumference and height h']" selected="vol_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,vol_r,lat_r,surf_r" hidden>
            <x-calc.field name="r" label="Radius r" value="5.15032" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,vol_h,lat_h,circ_h" hidden>
            <x-calc.field name="h" label="Height h" value="12" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Diameter" value="10.3006" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="1000" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:lat_r,lat_h" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="388.325" min="0" step="any" />
        </div>
        <div data-show-when="given:surf_r" hidden>
            <x-calc.field name="surf" label="Total surface area (unit²)" value="554.992" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ_h" hidden>
            <x-calc.field name="circ" label="Base circumference" value="32.3604" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol_h', 'unit' => 'cm', 'r' => 5.15032, 'h' => 12, 'd' => 10.3006, 'vol' => 1000, 'lat' => 388.325, 'surf' => 554.992, 'circ' => 32.3604],
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
            <li>d = 2√(V ÷ πh)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
