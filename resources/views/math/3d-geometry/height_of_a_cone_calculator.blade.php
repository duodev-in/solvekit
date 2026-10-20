<x-calc.page
    title="Height of a Cone Calculator - SolveKit"
    description="Free height of a cone calculator: h = 3V ÷ πr², or √(l² − r²) from the slant height."
    lede="Find a cone's height."
    about="From the volume, h = 3V/(πr²); from the slant height, h = √(l² − r²)."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'slant', 'd', 'vol', 'lat', 'angle'], 'shape' => 'cone', 'want' => 'h']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How tall is a cone of volume 100 with radius 3?', 'answer' => '10.61032954 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Base radius r and height h', 'd_h' => 'Base diameter and height h', 'r_slant' => 'Base radius r and slant height l', 'h_slant' => 'Height h and slant height l', 'vol_r' => 'Volume V and base radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and base radius r', 'r_angle' => 'Base radius r and half-angle at the apex']" selected="vol_r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,r_slant,vol_r,lat_r,r_angle" hidden>
            <x-calc.field name="r" label="Base radius r" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,h_slant,vol_h" hidden>
            <x-calc.field name="h" label="Height h" value="10.6103" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_slant,h_slant" hidden>
            <x-calc.field name="slant" label="Slant height l" value="11.0263" min="0" step="any" />
        </div>
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Base diameter" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="100" min="0" step="any" />
        </div>
        <div data-show-when="given:lat_r" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="103.92" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_angle" hidden>
            <x-calc.field name="angle" label="Half-angle at the apex (°)" value="15.7879" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Height h" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol_r', 'unit' => 'cm', 'r' => 3, 'h' => 10.6103, 'slant' => 11.0263, 'd' => 6, 'vol' => 100, 'lat' => 103.92, 'angle' => 15.7879],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Base radius r'],
            'h' => ['label' => 'Height h'],
            'slant' => ['label' => 'Slant height l'],
            'd' => ['label' => 'Base diameter'],
            'vol' => ['label' => 'Volume V'],
            'lat' => ['label' => 'Lateral surface area'],
            'base' => ['label' => 'Base area'],
            'surf' => ['label' => 'Total surface area'],
            'angle' => ['label' => 'Half-angle at the apex'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>h = 3V ÷ πr²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
